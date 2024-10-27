<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
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

        try {

            $this->exception = $exception;

            if (static::$errorImplementation) {
                $this->setError(Lng::get('implementation'));
                return false;
            }

            $isRequired = $this->isRequired();
            $isEmpty    = static::isEmpty($value);

            if ($isEmpty && !$isRequired) {
                return true;
            }

            if (!is_array($value) || !array_is_list($value)) {
                $this->setError(Lng::get('slice.list'));
                return false;
            } elseif ($isRequired && $isEmpty) {
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
        } catch (Exception $e) {

            $this->setErrorPath(
                message: $e->getMessage(),
                currentPath: '',
                field: null,
            );

            return false;
        } finally {
            static::$errorImplementation = false;
        }
    }

    public function info(): array {
        return [
            $this->typeValues->info()
        ];
    }
}
