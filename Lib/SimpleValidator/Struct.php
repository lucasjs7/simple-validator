<?php

namespace Lib\SimpleValidator;

class Struct {

	public function __construct(
		public readonly array $structure
	) {
		//
	}

	public static function new(array $structure): static {
		return new self($structure);
	}
}
