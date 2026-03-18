<?php

namespace Lucasjs7\SimpleValidator\Type;

class _Interface extends TypeBase {

    use tPattern, tRequired;

    public function typeValidate(
        mixed $value,
    ): bool {
        return true;
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        return;
    }

    public static function isEmpty(
        mixed $value,
    ): bool {
        return ((empty($value) && $value !== false) || parent::isEmpty($value) || (is_string($value) && trim($value) === ''));
    }
}
