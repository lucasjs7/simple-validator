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
		$strTrace = $exception->getTraceAsString();

		if (!ini_get('display_errors')) {
			error_log("AttrError: $errorMessage\n$strTrace");
		}

		$bkData = explode("\n", $strTrace);
		$penultBkData = (array_key_last($bkData) - 1);
		$bkTable = new SimpleCliTable;

		$bkTable->setContainsHeader(true);
		$bkTable->add(['Backtrace', 'Num']);

		for ($i = $penultBkData, $n = 1; $i > 0; $i--, $n++) {
			$posNum = (strpos($bkData[$i], ' ') + 1);

			$bkTable->add([
				substr($bkData[$i], $posNum),
				"#$n",
			]);
		}

		$exit = SimpleCliTable::build([["SimpleValidator - Attribute Error"], [$errorMessage]], true) . "\n";
		$exit .= $attrTable->render() . "\n";
		$exit .= $bkTable->render();

		exit($exit);
	}
}
