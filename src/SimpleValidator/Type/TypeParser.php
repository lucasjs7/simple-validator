<?php

namespace Lucasjs7\SimpleValidator\Type;

use Exception;
use Lucasjs7\SimpleValidator\Core;

class TypeParser {

	public static function new(string $value): TypeBase {
		try {
			$dataOpt = self::checkOptions($value);

			if (!array_key_exists('type', $dataOpt)) {
				throw new Exception('O parâmetro "type" é obrigatório.');
			} elseif (empty($dataOpt['type'])) {
				throw new Exception('Não foi atribuído valor ao parâmetro "type".');
			}

			$instance = match ($dataOpt['type']) {
				'string' => new _String,
				'int' 	 => new _Int,
				'float'  => new _Float,
				'bool' 	 => new _Bool,
				'date' 	 => new _Date,
				default  => null,
			};

			if ($instance === null) {
				throw new Exception("Não foi encontrado o \"type\" {$dataOpt['type']}.");
			}

			foreach ($dataOpt as $key => $value) {
				if ($key == 'type') {
					continue;
				}

				if (!method_exists($instance, $key)) {
					throw new Exception("O parâmetro $key não existe.");
				}

				if ($key === 'options') {
					$options = array_map('trim', explode(',', $value));
					$instance->{$key}(...$options);
				} elseif ($value !== null) {
					$instance->{$key}($value);
				} else {
					$instance->{$key}();
				}
			}

			return $instance;
		} catch (Exception $e) {

			Core::exitError(
				title: 'TypeParser',
				message: $e->getMessage(),
				exception: $e,
				backtrace: true,
			);
		}
	}

	private static function checkOptions(string $value): array {
		$dataVal = explode('|', $value);
		$dataOpt = [];

		foreach ($dataVal as $subVal) {
			$optList = explode(':', $subVal, 2);
			$optKey = $optList[0] ?? null;
			$optVal = $optList[1] ?? null;

			if ($optKey === null) {
				continue;
			}

			$fmtKey = trim($optKey);
			$fmtVal = ($optVal !== null) ? trim($optVal) : $optVal;

			if (empty($fmtKey)) {
				continue;
			}

			$dataOpt[$fmtKey] = $fmtVal;
		}

		return $dataOpt;
	}
}
