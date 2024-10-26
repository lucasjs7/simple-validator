<?php

namespace Lucasjs7\SimpleValidator\Type;

use Lucasjs7\SimpleValidator\Type\Attribute\tCallable;

class _Callable extends TypeBase {

    private static array $patterns = [];

    use tCallable, tPattern, tRequired;

    public function __construct(
        callable $callable,
        ?string  $label = null,
    ) {
        parent::__construct($label);

        $this->attr->callable->setValue($callable);
    }

    public static function new(
        ?string  $label = null,
        ?callable $callable = null,
    ): static {
        return new static($callable, $label);
    }

    public function typeValidate(
        mixed $value,
    ): bool {
        return true;
    }

    public function attrsValidate(
        mixed $value,
    ): void {
        $this->validateCallable($value);
    }

    public static function isEmpty(
        mixed $value,
    ): bool {
        return false;
    }

    public function error(
        string $message
    ) {
        $this->setError(
            message: $message,
            label: $this->attr->label->getValue(),
        );
    }
}
