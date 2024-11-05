<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\Attribute\tMaxDataSize;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class _File extends TypeBase {

    private static array $patterns = [];

    use tPattern, tRequired, tMaxDataSize;

    public function typeValidate(
        mixed $value,
    ): bool {

        $sFile = Struct::new([
            'name'      => 'type: string | required',
            'type'      => 'type: string | required',
            'size'      => 'type: int | required',
            'tmp_name'  => 'type: string | required',
            'full_path' => 'type: string | required',
            'error'     => 'type: int | required',
        ]);

        $isValid = $sFile->validate($value, false);

        if (!$isValid || !is_uploaded_file($value['tmp_name'])) {
            $this->setError(Lng::get('type.attribute.file.invalid'));
            return false;
        }

        return true;
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateMax($value);
    }
}
