<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
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
        mixed $value,
        bool  $exception = true,
    ): bool {

        $this->exception = $exception;

        if ($this->errorImplementation()) {
            $this->setError(Lng::get('implementation'));
            return false;
        }

        $isRequiredType = $this->isRequired();
        $isEmpty        = static::isEmpty($value);

        if (!$isRequiredType && $isEmpty) {
            return true;
        }

        if (!is_array($value) || !is_array($value)) {
            $this->setError(
                message: Lng::get('map.key_value'),
            );
            return false;
        } elseif ($isRequiredType && $isEmpty) {
            $this->setError(Lng::get('type.type_base.required'));
            return false;
        }

        foreach ($value as $key => $val) {

            if (!$this->typeKeys->validate($key, false, false)) {
                $this->setErrorPath(
                    message: $this->typeKeys->getError(),
                    currentPath: $key,
                    field: $this->typeKeys,
                );
                return false;
            }

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

    public function info(): array {
        return [
            'key'   => $this->typeKeys->info(),
            'value' => $this->typeValues->info(),
        ];
    }
}
