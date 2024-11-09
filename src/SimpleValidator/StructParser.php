<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionUnionType;
use Lucasjs7\SimpleValidator\Type\TypeParser;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class StructParser {

    public static function new(
        object|string $class,
    ): Struct {

        try {

            $dataStruct = [];

            $rfMethod = new ReflectionMethod($class, '__construct');
            $parameters = [];

            foreach ($rfMethod->getParameters() as $param) {

                $attribute = $param->getAttributes(TypeParser::class);
                $attrValue = null;

                foreach ($attribute as $attr) {
                    if ($attr->getName() === TypeParser::class) {
                        $attrValue = key_exists(0, $attr->getArguments()) ? $attr->getArguments()[0] : '';
                    }
                }

                $parameters[$param->name]['required'] = (!$param->isOptional());

                if ($attrValue !== null) {
                    $parameters[$param->name]['attribute'] = $attrValue;
                }
            }

            $rfClass = new ReflectionClass($class);

            foreach ($rfClass->getProperties() as $prop) {

                if (!key_exists($prop->name, $parameters)) {
                    continue;
                }

                if (!$prop->hasType()) {
                    throw new Exception;
                } elseif ($prop->getType() instanceof ReflectionUnionType) {
                    throw new Exception;
                } elseif ($prop->getType() instanceof ReflectionIntersectionType) {
                    throw new Exception;
                }

                $type  = $prop->getType();
                $tName = $type->getName();

                $docValidate = null;
                $parserRequired = null;
                $parserType = null;

                $existsAttr       = isset($parameters[$prop->name]['attribute']);
                $existsDocComment = (strpos($prop->getDocComment(), '@validate') !== false);

                if ($existsAttr && $existsDocComment) {
                    throw new Exception;
                }

                if ($existsAttr) {
                    $docValidate = $parameters[$prop->name]['attribute'];
                } elseif ($existsDocComment) {

                    preg_match('/@validate\s+(.*)$/m', $prop->getDocComment(), $mtDoc);

                    $docValidate = $mtDoc[1];

                    $dataOpt = TypeParser::checkOptions($docValidate);

                    if (key_exists('required', $dataOpt)) {
                        $parserRequired = $dataOpt['required'] ?? true;
                    }

                    if (key_exists('type', $dataOpt)) {

                        $parserType = match ($dataOpt['type']) {
                            'int'       => ($tName === 'int') ? 'int' : false,
                            'float'     => ($tName === 'float') ? 'float' : false,
                            'bool'      => ($tName === 'bool') ? 'bool' : false,
                            'string'    => ($tName === 'string') ? 'string' : false,
                            'date'      => ($tName === 'string') ? 'date' : false,
                            'file'      => ($tName === 'array') ? 'file' : false,
                            'image'     => ($tName === 'array') ? 'image' : false,
                            'mixed'     => 'mixed',
                            'interface' => 'interface',
                            'callable'  => 'callable',
                            default => false,
                        };

                        if ($parserType === false) {
                            throw new Exception;
                        }
                    }
                }

                $validTypes = ['int', 'float', 'bool', 'string', 'mixed'];

                if ($parserType === null && !in_array($tName, $validTypes)) {
                    throw new Exception;
                }

                $isRequired  = $parameters[$prop->name]['required'];

                if ($isRequired && ($parserRequired === false || $parserRequired === 'false')) {
                    throw new Exception;
                }

                $strParser  = ($parserType === null) ? "type: $tName | $docValidate" : $docValidate;
                $typeParser = TypeParser::new($strParser);

                if ($typeParser === false) {
                    throw new Exception;
                }

                if ($isRequired) {
                    $typeParser->required();
                }

                $dataStruct[$prop->name] = $typeParser;
            }

            if (empty($dataStruct)) {
                throw new Exception;
            }

            return Struct::new($dataStruct);
        } catch (Exception $e) {

            Core::exitError(
                title: 'TypeParser',
                message: Lng::get('implementation'),
                exception: $e,
                backtrace: true,
            );

            $typeError = new Struct([]);

            $typeError->errorImplementation = true;

            return $typeError;
        }
    }
}
