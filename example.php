<?php

ini_set('error_log', 'error_log.txt');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Lucasjs7\SimpleValidator\{Map, Slice, Struct, ValidatorException};
use Lucasjs7\SimpleValidator\Language\Language as Lng;
use Lucasjs7\SimpleValidator\Language\eLanguage as eLng;
use Lucasjs7\SimpleValidator\Type\{_String, _Date, _Int, _Float, _Bool};

try {

	Lng::set(eLng::PT);
	_Date::new()->format('d-m-Y')->save('br');

	$person = Struct::new([
		'nome' 		=> _String::new()->max(10)->min(5)->required(),
		'sobrenome' => _String::new()->max(16)->min(3),
		'idade' 	=> _Int::new()->max(150)->unsigned()->required(),
		'veiculos'  => Slice::new(
			Struct::new([
				'tipo' 	   => _String::new()->options('carro', 'moto', 'bicicleta')->required(),
				'sinistro' => _Bool::new()->required(),
				'fipe' 	   => _Float::new()->min(0)->required(),
				'donos' => Slice::new(
					Struct::new([
						'nome' 		=> _String::new()->max(10)->min(5)->required(),
						'posse_de'  => _Date::pattern('br')->required(),
						'posse_ate' => _Date::new()->format('Y-m-d H:i:s')->required(),
					]),
				),
				'informacoes_adicionais' => Map::new(
					_Date::pattern('br')->required(),
					_String::new()->min(16)->max(64)->required(),
				)
			]),
		),
	]);

	$person->validate([
		'nome' 		=> 'Teste',
		'sobrenome' => 'novo',
		'idade' 	=> 1,
		'veiculos'  => [
			[
				'tipo' 	   => 'bicicleta',
				'sinistro' => false,
				'fipe' 	   => 1.9,
				'donos' => [
					[
						'nome' 		=> 'Sidinelson',
						'posse_de'  => '01-01-2001',
						'posse_ate' => '2007-05-14 21:09:00',
					],
				],
				'informacoes_adicionais' => [
					'12-12-12112' => 'asdasdasdasdasdasdassdasd'
				]
			],
		],
	]);

	echo "Status: sucesso\n";
} catch (ValidatorException $e) {
	$e->debug();

	$errorPath = implode('->', $e->getErrorPath());

	echo "Status: error\n";
	echo "Message: {$e->getMessage()}\n";
	echo "Error path: $errorPath";
}
