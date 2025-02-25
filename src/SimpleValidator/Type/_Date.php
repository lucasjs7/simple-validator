<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\{tFormat};

class _Date extends TypeBase {

    public static $defaultFormat = 'Y-m-d';

    private static array $patterns = [];

    use tFormat, tPattern, tRequired;

    public function __construct() {
        parent::__construct();

        if ($this->getAttr()->format->getValue() === null) {
            $this->getAttr()->format->setValue(static::$defaultFormat);
        }
    }

    public function typeValidate(mixed $value): bool {
        return is_string($value);
    }

    public function attrsValidate(mixed $value): void {
        $this->validateFormat($value);
    }
}
