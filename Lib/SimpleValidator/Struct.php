<?php

namespace Lib\SimpleValidator;

class Struct {

	private string $errorMsg = '';

	public function __construct(
		private array $map
	) {
		//
	}

	public static function new(array $map): static {
		return new self($map);
	}
}
