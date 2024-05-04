<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tMin {

    public function min(
        float $value,
    ): static {
        $this->attr->min->setValue($value);
        return $this;
    }

    public function validateMin(
        mixed $value,
        string $type,
    ): void {
        $minIsEmpty = self::isEmpty($this->attr->min->getValue());

        if ($minIsEmpty) {
            return;
        }

        $maxIsEmpty = self::isEmpty($this->attr->max->getValue());

        if (!$maxIsEmpty && $this->attr->min->getValue() > $this->attr->max->getValue()) {
            $this->attr->min->setError(true);
            $this->attr->max->setError(true);

            AttrError::buildError(
                attr: $this->attr,
                errorMessage: Lng::get([], 'type', 'attribute', 'min', 'error-max'),
            );
        }

        $isValid = match ($type) {
            'int', 'float' => ($value >= $this->attr->min->getValue()),
            'string'       => (mb_strlen($value) >= $this->attr->min->getValue()),
        };

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get(['value' => $this->attr->min->getValue()], 'type', 'attribute', 'min', 'error-invalid'),
            );
        };
    }
}
