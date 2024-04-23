<?php

ini_set('error_log', 'error_log.txt');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Lib\SimpleValidator\{Map, Slice, Struct, ValidatorException};
use Lib\SimpleValidator\Type\{_String, _Date, _Int, _Float, _Bool};

try {

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
				// 'descricao_detalhada' => Type::$bigString,
				'donos' => Slice::new(
					Struct::new([
						'nome' 		=> _String::new()->max(10)->min(5)->required(),
						'posse_de'  => _Date::pattern('br')->required(),
						'posse_ate' => _Date::pattern('br')->required(),
					]),
				),
			])
		)
	]);

	$person->validate([
		'nome' 		=> 'Teste',
		'sobrenome' => 'novo',
		'idade' 	=> 14,
		'veiculos'  => [
			[
				'tipo' 	   => 'carro',
				'sinistro' => false,
				'fipe' 	   => 1.99,
				// 'descricao_detalhada' => '',
				'donos' => [
					[
						'nome' 		=> 'Sidinelson',
						'posse_de'  => '01-01-2001',
						'posse_ate' => '07-0a1-2016',
					],
				],
			]
		]
	]);

	echo "Status: sucesso\n";
} catch (ValidatorException $e) {
	$errorPath = implode('->', $e->getErrorPath());

	echo "Status: error\n";
	echo "Message: {$e->getMessage()}\n";
	echo "Error path: $errorPath";
}
