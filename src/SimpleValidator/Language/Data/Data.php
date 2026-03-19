<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

abstract class Data {

    /**
     * @return array<string, mixed>
     */
    abstract public static function get(): array;
}
