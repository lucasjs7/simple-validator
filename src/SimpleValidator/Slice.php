<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\{TypeBase, TypeParser};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class Slice extends DataStructure {

    public readonly DataStructure|TypeBase $typeValues;

    public function __construct(
        string|DataStructure|TypeBase $typeValues,
    ) {
        parent::__construct();

        $this->typeValues = !is_string($typeValues) ? $typeValues : TypeParser::new($typeValues);
    }

    public static function new(
        string|DataStructure|TypeBase $typeValues
    ): static {
        return new static($typeValues);
    }

    public function validate(
        mixed $values,
        bool  $exception = true,
    ): bool {

        $this->exception = $exception;

        if (($values === null || $values === []) && !$this->childrenRequired()) {
            return true;
        }

        if (!is_array($values) || !array_is_list($values)) {
            $this->setError(Lng::get('slice.list'));
            return false;
        }

        $isTypeBase     = ($this->typeValues instanceof TypeBase);
        $isRequiredType = ($isTypeBase && $this->typeValues->attr->required->getValue());

        if ($isRequiredType && TypeBase::isEmpty($values)) {
            $this->setError(Lng::get('type.type_base.required'));
            return false;
        }

        foreach ($values as $key => $val) {

            $this->typeValues->setPath([...$this->path, $key]);

            if (!$this->typeValues->validate($val, false)) {
                $this->setErrorPath(
                    message: $this->typeValues->getError(),
                    currentPath: $key,
                    field: $this->typeValues,
                );
                return false;
            }
        }

        return true;
    }

    public function childrenRequired(): bool {

        if ($this->typeValues instanceof DataStructure) {
            if ($this->typeValues->childrenRequired()) {
                return true;
            }
        } elseif ($this->typeValues->attr->required->getValue()) {
            return true;
        }

        return false;
    }

    public function info(): array {
        return [
            $this->typeValues->info()
        ];
    }
}
