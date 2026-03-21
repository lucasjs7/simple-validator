<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

/**
 * @phpstan-require-extends \Lucasjs7\SimpleValidator\Type\TypeBase
 */
trait tHeight {

    public function height(
        int $value,
    ): static {
        $this->getAttr()->height->setValue($value);
        return $this;
    }

    /**
     * @throws ValidatorException
     */
    public function validateHeight(
        mixed $value,
    ): void {

        if (static::isEmpty($this->getAttr()->height->getValue())) {
            return;
        }

        $imgSize = getimagesize($value['tmp_name']);
        $isValid = (isset($imgSize[1]) && $imgSize[1] <= $this->getAttr()->height->getValue());

        if (!$isValid) {

            throw new ValidatorException(
                message: Lng::get('type.attribute.height.over', ['value' => $this->getAttr()->height->getValue()]),
            );
        };
    }
}
