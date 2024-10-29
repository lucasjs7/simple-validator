<?php

use Lucasjs7\SimpleValidator\{Map, Slice, Struct};
use Lucasjs7\SimpleValidator\Type\_String;

function testUpload() {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'host.docker.internal/tests/Types/_File/testUpload.php');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile(__DIR__ . DIRECTORY_SEPARATOR . 'file.txt'),
    ]);

    $response = curl_exec($curl);

    curl_close($curl);

    // var_dump('Response:', $response);
    // var_dump('Error:', curl_error($curl));

    return json_decode($response, true);
}

function testTypeList(
    array $list,
) {

    $rtn = [];

    foreach ($list as $k => $v) {

        $value = key_exists('value', $v) ? $v['value'] : [];
        $test  = $v['test']->validate($value, false);
        $valid = ($test === $v['result']);

        $rtn[] = ['name' => $k, 'expect' => $v['result'], 'result' => $test];

        if (!$valid) {
            throw new Exception;
        }
    }

    return $rtn;
}

function testSlice(
    array $list,
) {

    $rtn = [];

    foreach ($list as $k => $v) {
        $value = key_exists('value', $v) ? [$v['value']] : [];
        $test = Slice::new($v['test'])->validate($value, false);
        $valid = ($test === $v['dataResult']);

        $rtn[] = ['name' => "Slice/$k", 'expect' => $v['dataResult'], 'result' => $test];

        if (!$valid) {
            throw new Exception;
        }
    }

    return $rtn;
}

function testMap(
    array $list,
) {

    $rtn = [];

    foreach ($list as $k => $v) {
        $value = key_exists('value', $v) ? ['name' => $v['value']] : [];
        $test = Map::new(
            typeKeys: _String::new(),
            typeValues: $v['test'],
        )->validate($value, false);
        $valid = ($test === $v['dataResult']);

        $rtn[] = ['name' => "Map/$k", 'expect' => $v['dataResult'], 'result' => $test];

        if (!$valid) {
            throw new Exception;
        }
    }

    return $rtn;
}

function testStruct(
    array $list,
) {

    $rtn = [];

    foreach ($list as $k => $v) {
        $value = key_exists('value', $v) ? ['A' => $v['value']] : [];
        $test = Struct::new(['A' => $v['test']])->validate($value, false);
        $valid = ($test === $v['dataResult']);

        $rtn[] = ['name' => "Struct/$k", 'expect' => $v['dataResult'], 'result' => $test];

        if (!$valid) {
            throw new Exception;
        }
    }

    return $rtn;
}
