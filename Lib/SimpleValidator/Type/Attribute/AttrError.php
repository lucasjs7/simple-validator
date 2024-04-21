<?php

namespace Lib\SimpleValidator\Type\Attribute;

use Exception;
use Lib\SimpleValidator\Core;
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
		$titleHeader = 'Attribute Error';
		$titleLib = Core::genHeaderError($titleHeader);
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

		Core::exitError(
			$titleHeader,
			$errorMessage,
			$exception,
			$attrTable,
			$bkTable,
		);
	}
}
