<?php

namespace Lucasjs7\SimpleValidator;

use Exception;
use Lucasjs7\SimpleCliTable;
use Lucasjs7\SimpleValidator\Language\{Language, eLanguage};

abstract class Core {

	protected string 	$errorMsg  = '';
	protected bool 		$exception = true;

	public static eLanguage $language;

	public function __construct() {
		if (self::$language === null) {
			Language::set(eLanguage::EN);
		}
	}

	protected function setError(
		string $message,
		array  $errorPath = [],
	): void {
		$this->errorMsg = $message;

		if ($this->exception) {
			throw new ValidatorException(
				message: $message,
				errorPath: $errorPath,
			);
		}
	}

	public function getError(): string {
		return $this->errorMsg;
	}

	public static function genHeaderError(string $title): string {
		return "SimpleValidator - $title";
	}

	public static function exitError(
		string 			   $title,
		string 			   $message,
		Exception 		   $exception,
		bool			   $backtrace,
		?SimpleCliTable ...$tables,
	): void {
		$headerData = [
			[self::genHeaderError($title)],
			[$message],
		];

		echo SimpleCliTable::build($headerData, true) . "\n";

		foreach ($tables as $table) {
			if ($table === null) continue;

			echo $table->render() . "\n";
		}

		if ($backtrace) {
			$trace = $exception->getTrace();
			$lastTrace = (array_key_last($trace));
			$bkTable = new SimpleCliTable;

			$bkTable->setContainsHeader(true);
			$bkTable->add(['', 'Backtrace', 'Function', 'Args']);

			for ($i = $lastTrace, $n = 1; $i > 0; $i--, $n++) {
				$traceFile 	   = $trace[$i]['file'] ?? '-';
				$traceLine 	   = $trace[$i]['line'] ?? '-';
				$traceFunction = $trace[$i]['function'] ?? '';
				$traceArgs 	   = $trace[$i]['args'] ?? '';

				$bkTable->add([
					"#$n",
					"$traceFile:$traceLine",
					$traceFunction,
					json_encode($traceArgs),
				]);
			}

			echo $bkTable->render();
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
