<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\TypeParser;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionUnionType;

class StructParser {

    public static function new(
        object|string $class,
    ): Struct|false {

        $dataStruct = [];

        $rfMethod = new ReflectionMethod($class, '__construct');
        $parameters = [];

        foreach ($rfMethod->getParameters() as $param) {
            $parameters[$param->name] = ['required' => (!$param->isOptional())];
        }

        $rfClass = new ReflectionClass($class);

        foreach ($rfClass->getProperties() as $prop) {

            if (!key_exists($prop->name, $parameters)) {
                continue;
            }

            if (!$prop->hasType()) {
                return false;
            } elseif ($prop->getType() instanceof ReflectionUnionType) {
                return false;
            } elseif ($prop->getType() instanceof ReflectionIntersectionType) {
                return false;
            }

            $type  = $prop->getType();
            $tName = $type->getName();

            $docValidate = null;
            $parserRequired = null;
            $parserType = null;

            if (strpos($prop->getDocComment(), '@validate') !== false) {

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
                        return false;
                    }
                }
            }

            $validTypes = ['int', 'float', 'bool', 'string', 'mixed'];

            if ($parserType === null && !in_array($tName, $validTypes)) {
                return false;
            }

            $isRequired  = $parameters[$prop->name]['required'];

            if ($isRequired && ($parserRequired === false || $parserRequired === 'false')) {
                return false;
            }

            $strParser  = ($parserType === null) ? "type: $tName | $docValidate" : $docValidate;
            $typeParser = TypeParser::new($strParser);

            if ($typeParser === false) {
                return false;
            }

            if ($isRequired) {
                $typeParser->required();
            }

            $dataStruct[] = $typeParser;
        }

        if (empty($dataStruct)) {
            return false;
        }

        return Struct::new($dataStruct);
    }
}
