<?php

namespace Lucasjs7\SimpleValidator;

use \Exception;
use Lucasjs7\SimpleValidator\Type\{TypeBase, TypeParser, _String};
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class Struct extends DataStructure {

    public function __construct(
        public array $structure
    ) {
        parent::__construct();

        foreach ($this->structure as $key => &$val) {

            if (!is_string($key)) {
                static::exitError(
                    title: 'Struct Error',
                    message: Lng::get('struct.key'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
                $this->errorImplementation = true;
                return;
            }

            if (!is_string($val) && !($val instanceof DataStructure) && !($val instanceof TypeBase)) {
                static::exitError(
                    title: 'Struct Error',
                    message: Lng::get('struct.data'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
                $this->errorImplementation = true;
                return;
            }

            if (is_string($val)) {
                $val = TypeParser::new(
                    value: $val,
                );
            }
        }
    }

    public static function new(
        array $structure,
    ): static {
        return new self($structure);
    }

    public function validate(
        mixed  $value,
        bool   $exception = true,
    ): bool {

        $this->exception = $exception;

        if ($this->errorImplementation()) {
            $this->setError(Lng::get('implementation'));
            return false;
        } elseif (!is_array($value)) {
            $this->setError(Lng::get('struct.list'), []);
            return false;
        }

        $typeKey = _String::new();

        foreach ($this->structure as $stcKey => $stcVal) {

            $key = key_exists($stcKey, $value) ? $stcKey : null;

            if ($key === null && !$stcVal->isRequired()) {
                continue;
            }

            $subValue = ($key !== null) ? $value[$stcKey] : null;

            if (!$typeKey->validate($key, false, false)) {
                $this->setErrorPath(
                    message: $typeKey->getError(),
                    currentPath: $stcKey,
                    field: $typeKey,
                );
                return false;
            }

            $stcVal->setPath([...$this->path, $stcKey]);

            $dataValidateValue = [
                'value'     => $subValue,
                'exception' => false,
            ];

            if ($stcVal instanceof TypeBase) {
                $dataValidateValue['selfField'] = false;
            }

            if (!$stcVal->validate(...$dataValidateValue)) {
                $this->setErrorPath(
                    message: $stcVal->getError(),
                    currentPath: $stcKey,
                    field: $stcVal,
                );
                return false;
            }
        }

        return true;
    }

    public function info(): array {
        $rtn = [];

        foreach ($this->structure as $key => $value) {
            $rtn[$key] = $value->info();
        }

        return $rtn;
    }
}
