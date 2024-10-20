<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\{tMin, tMax, tUnsigned};

class _Float extends TypeBase {

    private static array $patterns = [];

    use tMin, tMax, tPattern, tUnsigned, tRequired;

    public function typeValidate(
        mixed $value,
    ): bool {
        return ($value !== true && filter_var($value, FILTER_VALIDATE_FLOAT) !== false);
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateUnsigned($value);
        $this->validateMin($value, 'float');
        $this->validateMax($value, 'float');
    }
}
