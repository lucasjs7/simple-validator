<?php

ini_set('error_log', 'error_log.txt');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Lucasjs7\SimpleValidator\{Map, Slice, Struct, ValidatorException};
use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Language\eLanguage as eLng;
use Lucasjs7\SimpleValidator\Type\{TypeParser, _String, _Date, _Int, _Float, _Bool, _Interface};

try {

    Lng::set(eLng::PT);
    _Date::new()->format('d-m-Y')->save('br');

    // $person = Struct::new([
    //     'first_name' => _String::new('Nome')->max(10)->min(5)->required(),
    //     'last_name'  => _String::new()->max(16)->min(3),
    //     'age'        => _Int::new()->max(150)->unsigned()->required(),
    //     'vehicle'    => Slice::new(
    //         Struct::new([
    //             'type'     => _String::new()->options('carro', 'moto', 'bicicleta')->required(),
    //             'sinister' => _Bool::new()->required(),
    //             'fipe'     => _Float::new()->min(0)->required(),
    //             'owners'   => Slice::new(
    //                 Struct::new([
    //                     'name'       => _String::new()->max(10)->min(5)->required(),
    //                     'owner_from' => _Date::pattern('br')->required(),
    //                     'owner_to'   => _Date::new()->format('Y-m-d H:i:s')->required(),
    //                 ]),
    //             ),
    //             'additional_information' => Map::new(
    //                 _String::new()->min(1),
    //                 _Interface::new()->required()
    //             ),
    //         ]),
    //     ),
    // ]);

    $person = Struct::new([
        'first_name' => 'type: string | max: 10 | min: 5 | label: Nome | required',
        'last_name'  => 'type: string | max: 16 | min: 3',
        'age'        => 'type: int | max: 150 | unsigned | required',
        'vehicle'    => Slice::new(
            Struct::new([
                'type'     => 'type: string | options: carro, moto, bicicleta | required',
                'sinister' => 'type: bool | required',
                'fipe'     => 'type: float | min: 0',
                'owners'   => Slice::new(
                    Struct::new([
                        'name'       => 'type: string | max: 10 | min: 5 | required',
                        'owner_from' => 'type: date | pattern: br | required',
                        'owner_to'   => 'type: date | format: Y-m-d H:i:s | required',
                    ]),
                ),
                'additional_information' => Map::new(
                    'type: string | min: 1',
                    'type: mixed | required',
                ),
            ]),
        ),
    ]);

    $person->validate([
        'first_name' => 'Teste',
        'last_name'  => 'novo',
        'age'        => 1,
        'vehicle'    => [
            [
                'type'     => 'bicicleta',
                'sinister' => false,
                'fipe'     => 1.9,
                'owners'   => [
                    [
                        'name'       => 'Sidinelson',
                        'owner_from' => '11-11-1111',
                        'owner_to'   => '2007-05-14 21:09:00',
                    ],
                ],
                'additional_information' => [
                    'teste' => [1]
                ]
            ],
        ],
    ]);

    echo "Status: sucesso\n";
} catch (ValidatorException $e) {
    // $e->debug();

    $errorPath = implode('->', $e->getErrorPath());

    echo "Status: error\n";
    echo "Message: {$e->getMessage()}\n";
    echo "Error path: $errorPath";
}
