<?php

use Lucasjs7\SimpleValidator\Type\_Interface;

include 'Base.php';

$data = testUpload();
$status = $data['status'] ?? false;
$resultType = $data['resultType'] ?? [];
$resultDataStructure = $data['resultDataStructure'] ?? [];

if (empty($resultType) || empty($resultDataStructure)) {

    it('_File#' . __LINE__, function () {
        expect(true)->toBe(false);
    });
} else {

    foreach ($resultType as $tType) {

        it($tType['name'], function () use ($tType) {
            expect($tType['expect'])->toBe($tType['result']);
        });
    }

    foreach ($resultDataStructure as $tName => $tList) {

        describe($tName, function () use ($tList) {

            foreach ($tList as $tType) {
                it($tType['name'], function () use ($tType) {
                    expect($tType['expect'])->toBe($tType['result']);
                });
            }
        });
    }
}
