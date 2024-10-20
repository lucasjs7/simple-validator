<?php

namespace Tests;

use Lucasjs7\SimpleValidator\{Struct, Map, Slice};
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

    public static function testSlice(string $name, array $list) {
        describe($name, function () use ($list) {
            foreach ($list as $k => $v) {
                it($k, function () use ($v) {
                    $value = key_exists('value', $v) ?  [$v['value']] : [];
                    $test = Slice::new(
                        typeValues: $v['test'],
                    )->validate($value, false);

                    expect($test)->toBe($v['dataResult']);
                });
            }
        });
    }

    public static function testMap(string $name, array $list) {
        describe($name, function () use ($list) {
            foreach ($list as $k => $v) {
                it($k, function () use ($v) {
                    $value = key_exists('value', $v) ? ['name' => $v['value']] : [];
                    $test = Map::new(
                        typeKeys: _String::new(),
                        typeValues: $v['test'],
                    )->validate($value, false);

                    expect($test)->toBe($v['dataResult']);
                });
            }
        });
    }

    public static function testStruct(string $name, array $list) {
        describe($name, function () use ($list) {
            foreach ($list as $k => $v) {
                it($k, function () use ($v) {
                    $value = key_exists('value', $v) ? ['A' => $v['value']] : [];
                    $test = Struct::new(['A' => $v['test']])->validate($value, false);

                    expect($test)->toBe($v['dataResult']);
                });
            }
        });
    }
}
