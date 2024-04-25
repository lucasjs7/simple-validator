<?php

namespace Lucasjs7\SimpleValidator\Type;

trait tPattern {

	public function save(string $name): void {
		static::$patterns[$name] = serialize($this);
	}

	public static function pattern(string $name): static {
		return unserialize(static::$patterns[$name]);
	}
}
