<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class TypeParser {

    public static function new(
        string $value,
    ): TypeBase {
        try {
            $dataOpt = self::checkOptions($value);

            if (!array_key_exists('type', $dataOpt)) {
                throw new Exception(
                    message: Lng::get('type.parser.required'),
                );
            } elseif (empty($dataOpt['type'])) {
                throw new Exception(
                    message: Lng::get('type.parser.value'),
                );
            }

            $className = match ($dataOpt['type']) {
                'string'    => _String::class,
                'int'       => _Int::class,
                'float'     => _Float::class,
                'bool'      => _Bool::class,
                'date'      => _Date::class,
                'interface' => _Interface::class,
                'mixed'     => _Mixed::class,
                'callable'  => _Callable::class,
                default     => null,
            };

            if ($className === null) {
                throw new Exception(
                    message: Lng::get('type.parser.not_exists', ['type' => $dataOpt['type']]),
                );
            }

            $isPattern = (!empty($dataOpt['pattern']));
            $instance = $isPattern ? $className::pattern($dataOpt['pattern']) : $className::new();

            foreach ($dataOpt as $key => $value) {
                if (in_array($key, ['type', 'pattern'])) {
                    continue;
                }

                if (!method_exists($instance, $key)) {
                    throw new Exception(
                        message: Lng::get('type.parser.param', ['param' => $key]),
                    );
                }

                if ($key === 'options') {
                    $options = array_map('trim', explode(',', $value));
                    $instance->{$key}(...$options);
                } elseif ($value !== null) {
                    $instance->{$key}($value);
                } else {
                    $instance->{$key}();
                }
            }

            return $instance;
        } catch (Exception $e) {

            Core::exitError(
                title: 'TypeParser',
                message: $e->getMessage(),
                exception: $e,
                backtrace: true,
            );

            return new _Interface;
        }
    }

    private static function checkOptions(
        string $value,
    ): array {
        $dataVal = explode('|', $value);
        $dataOpt = [];

        foreach ($dataVal as $subVal) {
            $optList = explode(':', $subVal, 2);
            $optKey  = $optList[0] ?? null;
            $optVal  = $optList[1] ?? null;

            if ($optKey === null) {
                continue;
            }

            $fmtKey = trim($optKey);
            $fmtVal = ($optVal !== null) ? trim($optVal) : $optVal;

            if (empty($fmtKey)) {
                continue;
            }

            $dataOpt[$fmtKey] = $fmtVal;
        }

        return $dataOpt;
    }
}
