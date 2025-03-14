<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use DateTime;
use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tFormat {

    public function format(
        string $value,
    ): static {
        $this->getAttr()->format->setValue($value);

        return $this;
    }

    public function validateFormat(
        string $value,
    ): void {
        if (static::isEmpty($this->getAttr()->format->getValue())) {
            return;
        }

        $strFormat  = $this->getAttr()->format->getValue();
        $dateFormat = DateTime::createFromFormat($strFormat, $value);

        if ($dateFormat === false || $dateFormat->format($strFormat) != $value) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.format.invalid', ['value' => $strFormat]),
            );
        }
    }
}
