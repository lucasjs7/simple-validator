<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\{TypeBase, TypeParser};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class Map extends DataStructure {

    public readonly TypeBase               $typeKeys;
    public readonly TypeBase|DataStructure $typeValues;

    public function __construct(
        string|TypeBase               $typeKeys,
        string|TypeBase|DataStructure $typeValues,
    ) {
        parent::__construct();

        $this->typeKeys   = !is_string($typeKeys) ? $typeKeys : TypeParser::new($typeKeys);
        $this->typeValues = !is_string($typeValues) ? $typeValues : TypeParser::new($typeValues);
    }

    public static function new(
        string|TypeBase               $typeKeys,
        string|TypeBase|DataStructure $typeValues
    ): static {
        return new static($typeKeys, $typeValues);
    }

    public function validate(
        mixed $values,
        bool  $exception = true,
    ): bool {

        $this->exception = $exception;

        $isTypeBase      = ($this->typeValues instanceof TypeBase);
        $isDataStructure = ($this->typeValues instanceof DataStructure);
        $isRequiredType  = (($isTypeBase || $isDataStructure) && $this->childrenRequired());

        if (!$isRequiredType && TypeBase::isEmpty($values)) {
            return true;
        }

        if (!is_array($values) || !is_array($values)) {
            $this->setError(
                message: Lng::get('map.key_value'),
            );
            return false;
        }

        if ($isRequiredType && TypeBase::isEmpty($values)) {
            $this->setError(Lng::get('type.type_base.required'));
            return false;
        }

        foreach ($values as $key => $val) {

            if (!$this->typeKeys->validate($key, false)) {
                $this->setErrorPath(
                    message: $this->typeKeys->getError(),
                    currentPath: $key,
                    field: $this->typeKeys,
                );
                return false;
            }

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

        if ($this->typeKeys->attr->required->getValue()) {
            return true;
        }

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
            'key'   => $this->typeKeys->info(),
            'value' => $this->typeValues->info(),
        ];
    }
}
