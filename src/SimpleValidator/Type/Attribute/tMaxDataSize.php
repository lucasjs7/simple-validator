<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\ConvertDataSize\ConvertDataSize;
use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tMaxDataSize {

    public function max(
        string $value,
    ): static {

        $dataSize = ConvertDataSize::parser($value);

        if ($dataSize === false) {
            $this->attrError(
                attr: $this->getAttr(),
                errorMessage: Lng::get('type.attribute.max_data_size.invalid'),
            );

            return $this;
        }

        $this->getAttr()->max->setValue($dataSize);

        return $this;
    }

    public function validateMax(
        mixed  $value,
    ): void {

        if (static::isEmpty($this->getAttr()->max->getValue())) {
            return;
        }

        $isValid = (key_exists('size', $value) && $value['size'] <= $this->getAttr()->max->getValue());

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.max_data_size.over', ['size' => $this->getAttr()->max->getValue()]),
            );
        };
    }
}
