<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tPattern {

    /**
     * @var array<string, self>
     */
    private static array $patterns = [];

    public function save(
        string $name,
    ): void {
        self::$patterns[$name] = clone $this;
    }

    public static function pattern(
        string $name,
    ): self {
        if (!array_key_exists($name, self::$patterns)) {
            $typeName = self::name();
            Core::exitError(
                title: 'tPattern',
                message: Lng::get('type.pattern.not_exists', ['name' => $name, 'type' => $typeName]),
                exception: new Exception,
                backtrace: true,
            );

            $typeError = new self;

            $typeError->errorImplementation = true;

            return $typeError;
        }

        return self::$patterns[$name];
    }
}
