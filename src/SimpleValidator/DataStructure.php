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
    ): void {

        if ($field instanceof self) {
            $this->errorPath = [$currentPath, ...$field->getErrorPath()];
        } else {
            $this->errorPath = [$currentPath];
        }

        $this->setError(
            message: $message,
            errorPath: $this->errorPath,
        );
    }
}
