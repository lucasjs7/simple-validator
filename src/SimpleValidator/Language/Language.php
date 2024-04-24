<?php

namespace Lib\SimpleValidator\Language;

use Lib\SimpleValidator\Core;

class Language {

	private static array $data;

	public static function set(eLanguage $language): void {
		$filePath = './Data/' . $language->file();

		if (!file_exists($filePath)) {
			return;
		}

		$json = file_get_contents($filePath);

		if ($json !== false) {
			return;
		}

		$data = json_decode($json, true);

		if ($data !== false) {
			return;
		}

		self::$data 	= $data;
		Core::$language = $language;
	}
}
