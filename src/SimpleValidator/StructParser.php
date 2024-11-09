<?php

namespace Lucasjs7\SimpleValidator;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionUnionType;
use ReflectionParameter;
use ReflectionIntersectionType;
use Lucasjs7\SimpleValidator\Type\TypeParser;
use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Type\TypeBase;

class StructParser {

    public static function new(
        object|string $class,
    ): Struct {
        return static::method($class, '__construct');
    }

    public static function method(
        object|string $class,
        string        $method,
    ): Struct {

        try {

            $properties = [];

            if ($method === '__construct') {

                $rfClass = new ReflectionClass($class);

                foreach ($rfClass->getProperties() as $prop) {

                    if (strpos($prop->getDocComment(), '@validate') === false) {
                        continue;
                    }

                    $properties[$prop->name]['doc_comment'] = $prop->getDocComment();
                }
            }

            $dataStruct = static::processParameters(
                rf: new ReflectionMethod($class, $method),
                properties: $properties,
            );

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

    public static function function(
        Closure|string $function,
    ): Struct {

        try {

            $dataStruct = static::processParameters(
                rf: new ReflectionFunction($function),
                properties: [],
            );

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

    /**
     * @return TypeBase[]
     */
    private static function processParameters(
        ReflectionMethod|ReflectionFunction $rf,
        array                               $properties,
    ): array {

        $data = [];

        foreach ($rf->getParameters() as $param) {

            $listAttrs = $param->getAttributes(TypeParser::class);
            $attribute = null;

            foreach ($listAttrs as $attr) {
                if ($attr->getName() === TypeParser::class) {
                    $attribute = key_exists(0, $attr->getArguments()) ? $attr->getArguments()[0] : '';
                }
            }

            $required   = (!$param->isOptional());
            $docComment = $properties[$param->name]['doc_comment'] ?? '';

            $data[$param->name] = static::getType(
                param: $param,
                required: $required,
                attribute: $attribute,
                docComment: $docComment,
            );
        }

        return $data;
    }

    private static function getType(
        ReflectionParameter $param,
        bool                $required,
        ?string             $attribute,
        string              $docComment,
    ): TypeBase {

        if (!$param->hasType()) {
            throw new Exception;
        } elseif ($param->getType() instanceof ReflectionUnionType) {
            throw new Exception;
        } elseif ($param->getType() instanceof ReflectionIntersectionType) {
            throw new Exception;
        }

        $type  = $param->getType();
        $tName = $type->getName();

        $docValidate = null;
        $parserRequired = null;
        $parserType = null;

        if ($attribute !== null) {
            $docValidate = $attribute;
        } elseif (!empty($docComment)) {

            preg_match('/@validate\s+(.*)$/m', $docComment, $mtDoc);

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

        if ($required && ($parserRequired === false || $parserRequired === 'false')) {
            throw new Exception;
        }

        $strParser  = ($parserType === null) ? "type: $tName | $docValidate" : $docValidate;
        $typeParser = TypeParser::new($strParser);

        if ($typeParser === false) {
            throw new Exception;
        }

        if ($required) {
            $typeParser->required();
        }

        return $typeParser;
    }
}
