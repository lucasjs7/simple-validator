<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Closure;
use Exception;
use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Type\TypeBase;

/**
 * @phpstan-require-extends TypeBase
 */
trait tCallable {

    /**
     * @return TypeBase
     */
    abstract public function getAttr(): TypeBase;

    public function function(
        callable $value,
    ): static {
        $this->getAttr()->callable->setValue($value);

        return $this;
    }

    public function validateCallable(mixed $value): void {

        $callable = $this->getAttr()->callable->getValue();

        if (!is_callable($callable)) {
            static::exitError(
                title: 'Callable Error',
                message: Lng::get('type.attribute.callable.empty'),
                exception: new Exception,
                backtrace: true,
                tables: null,
            );
            $this->errorImplementation = true;
            return;
        }

        if ($callable instanceof Closure) {

            $callable = $callable->bindTo($this);

            if ($callable === null) {
                static::exitError(
                    title: 'Callable Error',
                    message: Lng::get('type.attribute.callable.invalid'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
                $this->errorImplementation = true;
                return;
            }
        }

        $isValid = ($callable($value) === true);

        if (!$isValid) {

            $msgError = $this->getError();

            if (empty($msgError)) {
                $msgError = Lng::get('type.attribute.callable.invalid');
            }

            throw new ValidatorException(message: $msgError);
        };
    }
}
