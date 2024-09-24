<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tMax {

    public function max(
        float $value,
    ): static {
        $this->attr->max->setValue($value);

        return $this;
    }

    public function validateMax(mixed $value, string $type): void {
        if (self::isEmpty($this->attr->max->getValue())) {
            return;
        }

        $isValid = match ($type) {
            'int', 'float' => ($value <= $this->attr->max->getValue()),
            'string'       => (mb_strlen($value) <= $this->attr->max->getValue()),
        };

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.max.invalid', ['value' => $this->attr->max->getValue()]),
            );
        };
    }
}
