<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use Throwable;
use Lucasjs7\SimpleValidator\Language\Language as Lng;

class ValidatorException extends Exception {

	private readonly array $errorPath;

	public function __construct(
		string 	   $message = '',
		int 	   $code = 0,
		?Throwable $previous = null,
		array      $errorPath = [],
	) {
		parent::__construct($message, $code, $previous);
		$this->errorPath = $errorPath;
	}

	public function getErrorPath(): array {
		return $this->errorPath;
	}

	public function debug(): void {
		Core::exitError(
			'ValidatorException',
			Lng::get([], 'exception', 'debug'),
			$this,
			true,
		);
	}
}
