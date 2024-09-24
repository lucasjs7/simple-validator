<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tUnsigned {

    public function unsigned(
        bool $value = true,
    ): static {
        $this->attr->unsigned->setValue($value);

        return $this;
    }

    public function validateUnsigned(
        mixed $value,
    ): void {
        if ($this->attr->unsigned->getValue() !== true) {
            return;
        }

        $isValid = ($value >= 0);

        if (!$isValid) {
            throw new ValidatorException(Lng::get('type.attribute.unsigned.invalid'));
        };
    }
}
