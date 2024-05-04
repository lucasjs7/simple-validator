<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\{tMin, tMax, tUnsigned};

class _Int extends TypeBase {

    private static array $patterns;

    use tMin, tMax, tPattern, tUnsigned, tRequired;

    public function typeValidate(
        mixed $value,
    ): bool {
        return (filter_var($value, FILTER_VALIDATE_INT) !== false);
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateUnsigned($value);
        $this->validateMin($value, 'int');
        $this->validateMax($value, 'int');
    }
}
