<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;

trait tPattern {

    public function save(
        string $name,
    ): void {
        static::$patterns[$name] = serialize($this);
    }

    public static function pattern(
        string $name,
    ): static {
        if (!array_key_exists($name, static::$patterns)) {
            $typeName = self::name();
            Core::exitError(
                title: 'tPattern',
                message: "O pattern '$name' do tipo '$typeName' não existe.",
                exception: new Exception,
                backtrace: true,
            );
        }

        return unserialize(static::$patterns[$name]);
    }
}
