<?php

namespace Lib\SimpleValidator\Type;

trait tNew {

	public static function new(): static {
		return new static;
	}
}
