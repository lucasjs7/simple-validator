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
                Core::exitError(
                    title: 'Struct Error',
                    message: Lng::get('struct.key'),
                    exception: new Exception,
                    backtrace: true,
                    tables: null,
                );
            }

            if (!is_string($val) && !($val instanceof DataStructure) && !($val instanceof TypeBase)) {
                Core::exitError(
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
        mixed $values,
        bool  $exception = true,
    ): bool {
        $this->exception = $exception;

        if (!is_array($values)) {
            $this->setError(Lng::get('struct.list'), []);
            return false;
        }

        $typeKey = _String::new();

        foreach ($this->structure as $stcKey => $stcVal) {
            $key   = array_key_exists($stcKey, $values) ? $stcKey : null;
            $value = ($key !== null) ? $values[$stcKey] : null;

            if (!$typeKey->validate($key, false)) {
                $this->setErrorPath(
                    message: $typeKey->getError(),
                    currentPath: $key,
                    field: $typeKey,
                );
                return false;
            }

            if (!$stcVal->validate($value, false)) {
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
