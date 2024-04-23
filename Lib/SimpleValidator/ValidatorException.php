<?php

namespace Lib\SimpleValidator;

use Exception;
use Throwable;

class ValidatorException extends Exception {

	private readonly array $errorPath;

	public function __construct(
		string 	 $message = '',
		int 	     $code = 0,
		?Throwable $previous = null,
		array      $errorPath = [],
	) {
		parent::__construct($message, $code, $previous);
		$this->errorPath = $errorPath;
	}

	public function getErrorPath(): array {
		return $this->errorPath;
	}
}
