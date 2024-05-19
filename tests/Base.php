<?php

namespace Tests;

use Lucasjs7\SimpleValidator\{Struct, Map};
use Lucasjs7\SimpleValidator\Type\_String;

class Base {

    public static function testTypeList(array $list) {
        foreach ($list as $k => $v) {
            it($k, function () use ($v) {
                $test = $v['test']->validate($v['value'], false);

                expect($test)->toBe($v['result']);
            });
        }
    }

    public static function testMap(string $name, array $list, bool $result) {
        describe($name, function () use ($list, $result) {
            foreach ($list as $k => $v) {
                it($k, function () use ($result, $v) {
                    $value = ['name' => $v['value']];
                    $test = Map::new(
                        typeKeys: _String::new(),
                        typeValues: $v['test'],
                    )->validate($value, false);

                    expect($test)->toBe($result);
                });
            }
        });
    }

    public static function testStruct(string $name, array $list, bool $result) {
        it($name, function () use ($list, $result) {
            $listTests = [];
            $listValues = [];

            foreach ($list as $k => $v) {
                $listTests[$k] = $v['test'];
                $listValues[$k] = $v['value'];
            }

            $test = Struct::new($listTests)->validate($listValues, false);

            expect($test)->toBe($result);
        });
    }
}
