<?php

namespace Lib\SimpleValidator;

use Exception;
use Lucasjs7\SimpleCliTable;

abstract class Core {

	protected string $errorMsg = '';
	protected bool $exception = true;

	protected function setError(string $message): void {
		$this->errorMsg = $message;

		if ($this->exception) {
			throw new ValidatorException($message);
		}
	}

	public function getError(): string {
		return $this->errorMsg;
	}

	public static function genHeaderError(string $title): string {
		return "SimpleValidator - $title";
	}

	public static function exitError(
		string 			  $title,
		string 			  $message,
		Exception 		  $exception,
		SimpleCliTable ...$tables,
	): void {
		$headerData = [
			[self::genHeaderError($title)],
			[$message],
		];

		echo SimpleCliTable::build($headerData, true) . "\n";

		foreach ($tables as $table) {
			echo $table->render() . "\n";
		}

		self::logFile($title, $message, $exception);
		exit;
	}

	public static function logFile(
		string 	  $title,
		string    $message,
		Exception $exception,
	): void {
		$fileErrorLog = ini_get('error_log');

		if (empty($fileErrorLog)) return;

		$strTrace 	= $exception->getTraceAsString();
		$logMessage = "$title: $message\n$strTrace\n";

		error_log($logMessage, 3, $fileErrorLog);
	}
}
