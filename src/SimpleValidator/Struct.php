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

        if (!is_array($values) && $values !== null && $values !== []) {
            $this->setError(Lng::get('struct.list'), []);
            return false;
        }

        $typeKey = _String::new();

        foreach ($this->structure as $stcKey => $stcVal) {

            $key      = isset($values[$stcKey]) ? $stcKey : null;
            $subValue = ($key !== null) ? $values[$stcKey] : null;

            if (!$typeKey->validate($key, false)) {
                $this->setErrorPath(
                    message: $typeKey->getError(),
                    currentPath: $key,
                    field: $typeKey,
                );
                return false;
            }

            $stcVal->setPath([...$this->path, $stcKey]);

            if (!$stcVal->validate($subValue, false)) {
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

    public function childrenRequired(): bool {

        foreach ($this->structure as $stcVal) {
            if ($stcVal instanceof DataStructure) {
                if ($stcVal->childrenRequired()) {
                    return true;
                }
            } elseif ($stcVal->attr->required->getValue()) {
                return true;
            }
        }

        return false;
    }

    public function info(): array {
        $rtn = [];

        foreach ($this->structure as $key => $value) {
            $rtn[$key] = $value->info();
        }

        return $rtn;
    }
}
