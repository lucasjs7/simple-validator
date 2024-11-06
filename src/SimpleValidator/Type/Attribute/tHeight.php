<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tHeight {

    public function height(
        int $value,
    ): static {
        $this->attr->height->setValue($value);
        return $this;
    }

    public function validateHeight(
        mixed $value,
    ): void {

        if (static::isEmpty($this->attr->height->getValue())) {
            return;
        }

        $imgSize = getimagesize($value['tmp_name']);
        $isValid = (isset($imgSize[1]) && $imgSize[1] <= $this->attr->height->getValue());

        if (!$isValid) {

            throw new ValidatorException(
                message: Lng::get('type.attribute.height.over', ['value' => $this->attr->height->getValue()]),
            );
        };
    }
}
