<?php

namespace Lucasjs7\SimpleValidator\Type;

class _Interface extends TypeBase {

    private static array $patterns;

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
}
