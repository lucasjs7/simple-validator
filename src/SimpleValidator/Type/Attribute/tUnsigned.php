<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

/**
 * @phpstan-require-extends \Lucasjs7\SimpleValidator\Type\TypeBase
 */
trait tUnsigned {

    public function unsigned(
        bool $value = true,
    ): static {
        $this->getAttr()->unsigned->setValue($value);

        return $this;
    }

    /**
     * @throws ValidatorException
     */
    public function validateUnsigned(
        mixed $value,
    ): void {
        if ($this->getAttr()->unsigned->getValue() !== true) {
            return;
        }

        $isValid = ($value >= 0);

        if (!$isValid) {
            throw new ValidatorException(Lng::get('type.attribute.unsigned.invalid'));
        };
    }
}
