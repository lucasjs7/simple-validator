<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\Attribute\{tMaxDataSize, tExt};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class _File extends TypeBase {

    use tPattern, tRequired, tMaxDataSize, tExt;

    /**
     * @phpstan-assert-if-true array{name: string, type: string, size: int, tmp_name: string, full_path: string, error: int} $value
     */
    public function typeValidate(
        mixed $value,
    ): bool {

        if (!is_array($value)) {
            return false;
        }

        $sFile = Struct::new([
            'name'      => 'type: string | required',
            'type'      => 'type: string | required',
            'size'      => 'type: int | required',
            'tmp_name'  => 'type: string | required',
            'full_path' => 'type: string | required',
            'error'     => 'type: int | required',
        ]);

        $isValid = $sFile->validate($value, false);

        if (!$isValid || !is_string($value['tmp_name']) || !is_uploaded_file($value['tmp_name'])) {
            $this->setError(Lng::get('type.attribute.file.invalid'));
            return false;
        }

        return true;
    }

    /**
     * @param array<string, mixed> $value
     */
    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateMax($value);
        $this->validateExt($value);
    }
}
