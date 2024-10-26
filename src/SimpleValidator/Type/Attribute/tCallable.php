<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tCallable {

    public function validateCallable(mixed $value): void {

        $callable = $this->attr->callable->getValue()->bindTo($this);
        $isValid  = ($callable($value) === true);

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.callable.invalid'),
            );
        };
    }
}
