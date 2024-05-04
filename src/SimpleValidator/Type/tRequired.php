<?php

namespace Lucasjs7\SimpleValidator\Type;

trait tRequired {

    public function required(
        bool $value = true,
    ): static {
        $this->attr->required->setValue($value);
        return $this;
    }
}
