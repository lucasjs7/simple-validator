<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tOptions {

    public function options(
        string ...$values
    ): static {
        $this->attr->options->setValue($values);
        return $this;
    }

    public function validateOptions(
        string $value,
    ): void {
        if (self::isEmpty($this->attr->options->getValue())) {
            return;
        }

        $isValid = in_array($value, $this->attr->options->getValue());

        if (!$isValid) {
            throw new ValidatorException(Lng::get([], 'type', 'attribute', 'options', 'error-invalid'));
        };
    }
}
