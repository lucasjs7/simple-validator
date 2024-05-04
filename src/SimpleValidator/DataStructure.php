<?php

namespace Lucasjs7\SimpleValidator;

use Lucasjs7\SimpleValidator\Type\TypeBase;

abstract class DataStructure extends Core implements iDataStructure {

    protected array $errorPath = [];

    public function getErrorPath(): array {
        return $this->errorPath;
    }

    protected function setErrorPath(
        string             $message,
        string             $currentPath,
        null|self|TypeBase $field,
        string             $prefix = '',
    ): void {
        $showPrefix = true;

        if ($field instanceof self) {
            $this->errorPath =  [$currentPath, ...$field->getErrorPath()];
            $showPrefix      = empty($field->getErrorPath());
        } else {
            $this->errorPath =  [$currentPath];
        }

        $this->setError(
            message: $showPrefix ? ($prefix . $message) : $message,
            errorPath: $this->errorPath,
        );
    }

    protected function showPrefixError(
        mixed $val,
    ): bool {
        $isSelfInstance = ($val instanceof self);
        $notIsInstance = (!($val instanceof self) && !($val instanceof TypeBase));

        return (($isSelfInstance || $notIsInstance) && empty($this->getErrorPath()));
    }
}
