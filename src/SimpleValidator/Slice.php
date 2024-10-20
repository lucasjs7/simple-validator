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
        mixed  $value,
        bool   $exception = true,
    ): bool {

        $this->exception = $exception;

        $isRequired = $this->childrenRequired();

        if (($value === null || $value === []) && !$isRequired) {
            return true;
        }

        if (!is_array($value) || !array_is_list($value)) {
            $this->setError(Lng::get('slice.list'));
            return false;
        } elseif ($isRequired && TypeBase::isEmpty($value)) {
            $this->setError(Lng::get('type.type_base.required'));
            return false;
        }

        foreach ($value as $key => $val) {

            $this->typeValues->setPath([...$this->path, $key]);

            $dataValidateValue = [
                'value'     => $val,
                'exception' => false,
            ];

            if ($this->typeValues instanceof TypeBase) {
                $dataValidateValue['selfField'] = false;
            }

            if (!$this->typeValues->validate(...$dataValidateValue)) {
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
