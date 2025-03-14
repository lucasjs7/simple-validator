<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tExt {

    public function ext(
        string ...$values
    ): static {

        $this->getAttr()->ext->setValue(array_map(function ($v) {
            return trim($v, '.');
        }, $values));

        return $this;
    }

    public function validateExt(
        array $value,
    ): void {

        if (static::isEmpty($this->getAttr()->ext->getValue())) {
            return;
        }

        $fileExt = substr($value['name'], (strrpos($value['name'], '.') + 1));
        $isValid = in_array($fileExt, $this->getAttr()->ext->getValue());

        if (!$isValid) {
            throw new ValidatorException(Lng::get('type.attribute.ext.invalid'));
        };
    }
}
