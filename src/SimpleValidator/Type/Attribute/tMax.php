<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tMax {

    public function max(
        float $value,
    ): static {
        $this->getAttr()->max->setValue($value);

        return $this;
    }

    public function validateMax(
        mixed  $value,
        string $type,
    ): void {

        if (static::isEmpty($this->getAttr()->max->getValue())) {
            return;
        }

        $isValid = match ($type) {
            'int', 'float' => ($value <= $this->getAttr()->max->getValue()),
            'string'       => (mb_strlen($value) <= $this->getAttr()->max->getValue()),
        };

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.max.invalid', ['value' => $this->getAttr()->max->getValue()]),
            );
        };
    }
}
