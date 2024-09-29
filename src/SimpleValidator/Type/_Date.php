<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\{tFormat};

class _Date extends TypeBase {

    public static $defaultFormat = 'd-m-Y';

    private static array $patterns = [];

    use tFormat, tPattern, tRequired;

    public function __construct() {
        parent::__construct();

        if ($this->attr->format->getValue() === null) {
            $this->attr->format->setValue(static::$defaultFormat);
        }
    }

    public function typeValidate(mixed $value): bool {
        return is_string($value);
    }

    public function attrsValidate(mixed $value): void {
        $this->validateFormat($value);
    }
}
