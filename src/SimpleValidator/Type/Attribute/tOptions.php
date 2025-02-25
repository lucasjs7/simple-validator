<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tOptions {

    public function options(
        string ...$values
    ): static {
        $this->getAttr()->options->setValue($values);
        return $this;
    }

    public function validateOptions(
        string $value,
    ): void {
        if (static::isEmpty($this->getAttr()->options->getValue())) {
            return;
        }

        $isValid = in_array($value, $this->getAttr()->options->getValue());

        if (!$isValid) {
            throw new ValidatorException(Lng::get('type.attribute.options.invalid'));
        };
    }
}
