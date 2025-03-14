<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tRegex {

    public function regex(
        string $pattern,
    ): static {

        if (@preg_match($pattern, '') === false) {
            $this->attrError(
                attr: $this->getAttr(),
                errorMessage: Lng::get('type.attribute.regex.pattern'),
            );

            return $this;
        }

        $this->getAttr()->regex->setValue($pattern);

        return $this;
    }

    public function validateRegex(
        mixed $value,
    ): void {
        if (static::isEmpty($this->getAttr()->regex->getValue())) {
            return;
        }

        $isValid = preg_match($this->getAttr()->regex->getValue(), $value);

        if ($isValid === 0) {
            throw new ValidatorException(Lng::get('type.attribute.regex.invalid', ['value' => $this->getAttr()->regex->getValue()]));
        }
    }
}
