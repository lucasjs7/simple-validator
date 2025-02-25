<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tMin {

    public function min(
        float $value,
    ): static {
        $this->getAttr()->min->setValue($value);
        return $this;
    }

    public function validateMin(
        mixed $value,
        string $type,
    ): void {
        $minIsEmpty = static::isEmpty($this->getAttr()->min->getValue());

        if ($minIsEmpty) {
            return;
        }

        $maxIsEmpty = static::isEmpty($this->getAttr()->max->getValue());

        if (!$maxIsEmpty && $this->getAttr()->min->getValue() > $this->getAttr()->max->getValue()) {
            $this->getAttr()->min->setError(true);
            $this->getAttr()->max->setError(true);

            $this->attrError(
                attr: $this->getAttr(),
                errorMessage: Lng::get('type.attribute.min.greater'),
            );

            return;
        }

        $isValid = match ($type) {
            'int', 'float' => ($value >= $this->getAttr()->min->getValue()),
            'string'       => (mb_strlen($value) >= $this->getAttr()->min->getValue()),
        };

        if (!$isValid) {

            $msgPath = match ($type) {
                'int', 'float' => 'type.attribute.min.invalid.number',
                'string'       => 'type.attribute.min.invalid.string',
            };

            throw new ValidatorException(
                message: Lng::get($msgPath, ['value' => $this->getAttr()->min->getValue()]),
            );
        };
    }
}
