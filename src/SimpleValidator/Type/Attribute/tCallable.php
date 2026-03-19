<?php

namespace Lucasjs7\SimpleValidator\Type\Attribute;

use Closure;
use Exception;
use Lucasjs7\SimpleValidator\ValidatorException;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

/**
 * @phpstan-require-extends \Lucasjs7\SimpleValidator\Type\TypeBase
 */
trait tCallable {

    /**
     * @return \Lucasjs7\SimpleValidator\Type\TypeBase
     */
    abstract public function getAttr(): \Lucasjs7\SimpleValidator\Type\TypeBase;

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
