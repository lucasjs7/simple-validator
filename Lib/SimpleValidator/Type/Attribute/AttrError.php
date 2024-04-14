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
		string $errorMessage,
	): void {
		$attrTable = new SimpleCliTable;

		$attrTable->setContainsHeader(true);
		$attrTable->add(['Attribute', 'Value', 'Error']);

		foreach ($attr as $kAttr => $vAttr) {
			$attrTable->add([
				$kAttr,
				$vAttr->getValue() ?? '',
				$vAttr->getError(),
			]);
		}

		$exception = new Exception();
		$bkData = explode("\n", $exception->getTraceAsString());
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

		$exit = SimpleCliTable::build([["SimpleValidator - Attribute Error"], [$errorMessage]], true);
		$exit .= $attrTable->render();
		$exit .= $bkTable->render();

		exit($exit);
	}
}
