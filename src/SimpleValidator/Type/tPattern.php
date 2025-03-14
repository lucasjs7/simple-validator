<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tPattern {

    public function save(
        string $name,
    ): void {
        static::$patterns[$name] = clone $this;
    }

    public static function pattern(
        string $name,
    ): static {
        if (!array_key_exists($name, static::$patterns)) {
            $typeName = self::name();
            Core::exitError(
                title: 'tPattern',
                message: Lng::get('type.pattern.not_exists', ['name' => $name, 'type' => $typeName]),
                exception: new Exception,
                backtrace: true,
            );

            $typeError = new static;

            $typeError->errorImplementation = true;

            return $typeError;
        }

        return static::$patterns[$name];
    }
}
