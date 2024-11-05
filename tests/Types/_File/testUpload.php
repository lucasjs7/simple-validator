<?php

use Lucasjs7\SimpleValidator\Type\_File;
use Lucasjs7\SimpleValidator\Type\TypeParser;

include '/var/www/html/vendor/autoload.php';
include 'Base.php';

$status = false;
$resultType = [];
$resultDataStructure = [];

try {

    $fileFalse = [
        'name'      => "file.txt",
        'full_path' => "/var/www/html/tests/Types/_File/file.txt",
        'type'      => "application/octet-stream",
        'tmp_name'  => "/tmp/test",
        'error'     => 0,
        'size'      => 300,
    ];

    $listTests = [
        'testUpload#' . __LINE__ => [
            'test' => _File::new(),
            'value' => $_FILES['file'],
            'result' => true,
            'dataResult' => true,
        ],
        'testUpload#' . __LINE__ => [
            'test' => TypeParser::new('type: file | required'),
            'value' => $_FILES['file'],
            'result' => true,
            'dataResult' => true,
        ],
        'testUpload#' . __LINE__ => [
            'test' => _File::new(),
            'value' => $fileFalse,
            'result' => false,
            'dataResult' => false,
        ],
        'testUpload#' . __LINE__ => [
            'test' => _File::new()->max('0.01B'),
            'value' => $_FILES['file'],
            'result' => false,
            'dataResult' => false,
        ],
        'testUpload#' . __LINE__ => [
            'test' => _File::new()->max('1MB'),
            'value' => $_FILES['file'],
            'result' => true,
            'dataResult' => true,
        ],
        'testUpload#' . __LINE__ => [
            'test' => _File::new()->max('343'),
            'value' => $_FILES['file'],
            'result' => false,
            'dataResult' => false,
        ],
    ];

    $resultType = testTypeList($listTests);

    $resultDataStructure['testUpload/Slice#1'] = testSlice($listTests);
    $resultDataStructure['testUpload/Map#1'] = testMap($listTests);
    $resultDataStructure['testUpload/Struct#1'] = testStruct($listTests);

    $status = true;
} catch (\Exception $e) {
    $status = false;
}

echo json_encode([
    'resultType'          => $resultType,
    'resultDataStructure' => $resultDataStructure,
    'status'              => $status,
]);
