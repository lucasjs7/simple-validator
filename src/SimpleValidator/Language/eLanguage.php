<?php

namespace Lucasjs7\SimpleValidator\Language;

use Lucasjs7\SimpleValidator\Language\Data\{Data, En, Pt};

enum eLanguage {
    case PT;
    case EN;

    /**
     * @return array<eLanguage, array<string, mixed>>
     */
    public function data(): array {
        return match ($this) {
            self::PT => Pt::get(),
            self::EN => En::get(),
        };
    }
}
