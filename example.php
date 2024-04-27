<?php

ini_set('error_log', 'error_log.txt');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Lucasjs7\SimpleValidator\{Map, Slice, Struct, ValidatorException};
use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Language\eLanguage as eLng;
use Lucasjs7\SimpleValidator\Type\{TypeParser, _String, _Date, _Int, _Float, _Bool};

try {

	Lng::set(eLng::PT);

	// $field = TypeParser::new('type: string | max: 10 | min: 5 | required');
	// $field->validate('teasdasdasdasdste');

	// echo 'sucesso';
	// exit;

	_Date::new()->format('d-m-Y')->save('br');

	// $person = Struct::new([
	// 	'nome' 		=> _String::new()->max(10)->min(5)->required(),
	// 	'sobrenome' => _String::new()->max(16)->min(3),
	// 	'idade' 	=> _Int::new()->max(150)->unsigned()->required(),
	// 	'veiculos'  => Slice::new(
	// 		Struct::new([
	// 			'tipo' 	   => _String::new()->options('carro', 'moto', 'bicicleta')->required(),
	// 			'sinistro' => _Bool::new()->required(),
	// 			'fipe' 	   => _Float::new()->min(0)->required(),
	// 			'donos' => Slice::new(
	// 				Struct::new([
	// 					'nome' 		=> _String::new()->max(10)->min(5)->required(),
	// 					'posse_de'  => _Date::pattern('br')->required(),
	// 					'posse_ate' => _Date::new()->format('Y-m-d H:i:s')->required(),
	// 				]),
	// 			),
	// 			'informacoes_adicionais' => Map::new(
	// 				_Date::pattern('br')->required(),
	// 				_String::new()->min(16)->max(64)->required(),
	// 			)
	// 		]),
	// 	),
	// ]);

	$person = Struct::new([
		'first_name' => 'type: string | max: 10 | min: 5 | required',
		'last_name' => 'type: string | max: 16 | min: 3',
		'age' => 'type: int | max: 150 | unsigned | required',
		'vehicle' => Slice::new(
			Struct::new([
				'type' => 'type: string | options: carro, moto, bicicleta | required',
				'sinister' => 'type: bool | required',
				'fipe' => 'type: float | min: 0',
				'owners' => Slice::new(
					Struct::new([
						'name' => 'type: string | max: 10 | min: 5 | required',
						'owner_from' => 'type: date | format: Y-m-d H:i:s | required',
						'owner_to' => 'type: date | format: Y-m-d H:i:s | required',
					]),
				),
				'additional_information' => Map::new(
					'type: string | min: 1 | required',
					'type: string | min: 16 | max: 64 | required',
				),
			]),
		),
	]);

	$person->validate([
		'first_name' => 'Teste',
		'last_name' => 'novo',
		'age' => 1,
		'vehicle' => [
			[
				'type' => 'bicicleta',
				'sinister' => false,
				'fipe' => 1.9,
				'owners' => [
					[
						'name' => 'Sidinelson',
						'owner_from' => '2007-05-14 21:09:00',
						'owner_to' => '2007-05-14 21:09:00',
					],
				],
				'additional_information' => [
					'test' => 'asdasdasdasdasdasdassdasd'
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
