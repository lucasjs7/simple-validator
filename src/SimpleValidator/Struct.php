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
                return static::exitError(
                    title: 'Struct Error',
                    message: Lng::get('struct.key'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
            }

            if (!is_string($val) && !($val instanceof DataStructure) && !($val instanceof TypeBase)) {
                return static::exitError(
                    title: 'Struct Error',
                    message: Lng::get('struct.data'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
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

        try {

            $this->exception = $exception;

            if (static::$errorImplementation) {
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
        $rtn = [];

        foreach ($this->structure as $key => $value) {
            $rtn[$key] = $value->info();
        }

        return $rtn;
    }
}
