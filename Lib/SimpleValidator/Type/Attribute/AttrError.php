<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Exception;
use Lucasjs7\SimpleCliTable;

/**
 * Esta classe só deve ser chamada quando ocorrer um uso
 * indevido dos atributos de um Type
 */
class AttrError {

	public static function buildError(
		Attribute $attr,
		string 	  $errorMessage,
	): void {
		$titleLib = 'SimpleValidator - Attribute Error';
		$attrTable = new SimpleCliTable;

		$attrTable->setContainsHeader(true);
		$attrTable->add(['Attribute', 'Value', 'Error']);

		foreach ($attr as $kAttr => $vAttr) {
			$attrValeu = match (gettype($vAttr->getValue())) {
				'array', 'object' => json_encode($vAttr->getValue()),
				'NULL' 			  => '',
				default => $vAttr->getValue(),
			};

			$attrTable->add([
				$kAttr,
				$attrValeu,
				$vAttr->getError() ? '*' : '',
			]);
		}

		$exception = new Exception();
		$trace = $exception->getTrace();
		$fileErrorLog = ini_get('error_log');

		if (!empty($fileErrorLog)) {
			$strTrace 	= $exception->getTraceAsString();
			$logMessage = "$titleLib: $errorMessage\n$strTrace\n";
			error_log($logMessage, 3, $fileErrorLog);
		}

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

		$exit = SimpleCliTable::build([[$titleLib], [$errorMessage]], true) . "\n";
		$exit .= $attrTable->render() . "\n";
		$exit .= $bkTable->render();

		exit($exit);
	}
}
