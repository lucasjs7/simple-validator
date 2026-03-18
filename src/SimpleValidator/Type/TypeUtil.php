<?php

namespace Lucasjs7\SimpleValidator\Type;

class TypeUtil {

    public static function String(): _String {
        return new _String;
    }

    public static function Int(): _Int {
        return new _Int();
    }

    public static function Float(): _Float {
        return new _Float();
    }

    public static function Date(): _Date {
        return new _Date();
    }

    public static function Bool(): _Bool {
        return new _Bool();
    }

    public static function Callable(): _Callable {
        return new _Callable();
    }

    public static function File(): _File {
        return new _File();
    }

    public static function Image(): _Image {
        return new _Image();
    }

    public static function Interface(): _Interface {
        return new _Interface();
    }

    public static function Mixed(): _Mixed {
        return new _Mixed();
    }
}
