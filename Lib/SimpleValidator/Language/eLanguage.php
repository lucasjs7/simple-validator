<?php

namespace Lib\SimpleValidator\Language;

enum eLanguage {
	case PT;
	case EN;

	public function file(): string {
		return match ($this) {
			self::PT => 'pt.json',
			self::EN => 'en.json',
		};
	}
}
