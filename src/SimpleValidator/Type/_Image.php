<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\{tHeight, tWidth, tMaxDataSize};

class _Image extends _File {

    private static array $patterns = [];

    use tPattern, tRequired, tMaxDataSize, tWidth, tHeight;

    public function typeValidate(
        mixed $value,
    ): bool {

        if (!parent::typeValidate($value)) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if ($finfo === false) {
            return false;
        }

        $fileMime = finfo_file($finfo, $value['tmp_name']);

        finfo_close($finfo);

        if ($fileMime === false || !str_starts_with($fileMime, 'image')) {
            return false;
        }

        return true;
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateMax($value);
        $this->validateHeight($value);
        $this->validateWidth($value);
    }
}
