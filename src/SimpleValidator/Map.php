<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\{TypeBase, _Date, _Int, _String, TypeParser};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class Map extends DataStructure {

    public readonly TypeBase               $typeKeys;
    public readonly TypeBase|DataStructure $typeValues;

    public function __construct(
        string|TypeBase               $typeKeys,
        string|TypeBase|DataStructure $typeValues,
    ) {
        $this->typeKeys   = !is_string($typeKeys) ? $typeKeys : TypeParser::new($typeKeys);
        $this->typeValues = !is_string($typeValues) ? $typeValues : TypeParser::new($typeValues);
    }

    public static function new(
        string|_Date|_Int|_String     $typeKeys,
        string|TypeBase|DataStructure $typeValues
    ): static {
        return new static($typeKeys, $typeValues);
    }

    public function validate(
        mixed $values,
        bool  $exception = true,
    ): bool {
        $this->exception = $exception;

        if (!is_array($values) || !is_array($values)) {
            $this->setError(
                message: Lng::get('map.key_value'),
            );
            return false;
        }

        $isTypeBase     = ($this->typeValues instanceof TypeBase);
        $isRequiredType = ($isTypeBase && $this->typeValues->attr->required->getValue());

        if ($isRequiredType && TypeBase::isEmpty($values)) {
            $this->setError(Lng::get('type.type_base.required'));
            return false;
        }

        foreach ($values as $key => $val) {
            if (!$this->typeKeys->validate($key, false)) {
                $this->setErrorPath(
                    message: Lng::get('map.prefix_key') . $this->typeKeys->getError(),
                    currentPath: $key,
                    field: $this->typeKeys,
                );
                return false;
            }
            if (!$this->typeValues->validate($val, false)) {
                $this->setErrorPath(
                    message: $this->typeValues->getError(),
                    currentPath: $key,
                    field: $this->typeValues,
                    prefix: Lng::get('map.prefix_value') . $val,
                );
                return false;
            }
        }

        return true;
    }

    public function info(): array {
        return [
            'key'   => $this->typeKeys->info(),
            'value' => $this->typeValues->info(),
        ];
    }
}
