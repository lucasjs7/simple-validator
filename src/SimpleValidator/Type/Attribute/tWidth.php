<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tWidth {

    public function width(
        int $value,
    ): static {
        $this->getAttr()->width->setValue($value);
        return $this;
    }

    public function validateWidth(
        mixed $value,
    ): void {

        if (static::isEmpty($this->getAttr()->width->getValue())) {
            return;
        }

        $imgSize = getimagesize($value['tmp_name']);
        $isValid = (isset($imgSize[0]) && $imgSize[0] <= $this->getAttr()->width->getValue());

        if (!$isValid) {

            throw new ValidatorException(
                message: Lng::get('type.attribute.width.over', ['value' => $this->getAttr()->width->getValue()]),
            );
        };
    }
}
