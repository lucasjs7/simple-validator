<?php

namespace Lucasjs7\SimpleValidator\Language;

use Lucasjs7\SimpleValidator\Core;

class Language {

	private static array $data = [];

	public static function defaultLang(): void {
		self::set(eLanguage::EN);
	}

	public static function set(eLanguage $language): void {
		self::$data 	= $language->data();
		Core::$language = $language;
	}

	public static function get(array $dataReplace, string ...$path): string {
		if (!isset(Core::$language)) {
			Language::defaultLang();
		}

		$currentData = self::$data;

		foreach ($path as $dir) {
			if (array_key_exists($dir, $currentData)) {
				$currentData = $currentData[$dir];
			}
		}

		if (!is_string($currentData)) {
			return '';
		}

		foreach ($dataReplace as $key => $value) {
			$tag = '{{' . $key . '}}';
			$currentData = str_replace($tag, $value, $currentData);
		}

		return is_string($currentData) ? $currentData : '';
	}
}
