<?php

namespace Lucasjs7\SimpleValidator\Type;

trait tNew {

	public static function new(): static {
		return new static;
	}
}
