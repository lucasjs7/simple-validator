<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Closure;
use Exception;
use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

trait tCallable {

    public function function(
        callable $value,
    ): static {
        $this->attr->callable->setValue($value);

        return $this;
    }

    public function validateCallable(mixed $value): void {

        $callable = $this->attr->callable->getValue();

        if (!is_callable($callable)) {
            static::exitError(
                title: 'Callable Error',
                message: Lng::get('type.attribute.callable.empty'),
                exception: new Exception,
                backtrace: true,
                tables: null,
            );
            return;
        } elseif (!($callable instanceof Closure)) {
            static::exitError(
                title: 'Callable Error',
                message: Lng::get('type.attribute.callable.anonymous'),
                exception: new Exception,
                backtrace: true,
                tables: null,
            );
            return;
        }

        $newCallable = $callable->bindTo($this);
        $isValid  = ($newCallable($value) === true);

        if (!$isValid) {
            throw new ValidatorException(
                message: Lng::get('type.attribute.callable.invalid'),
            );
        };
    }
}
