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
		'sobrenome' => _String::new()->max(16)->min(4),
		'idade' 	=> _Int::new()->max(150)->unsigned()->required(),
		'veiculos'  => [
			[
				'tipo' 	   => _String::new()->options('carro', 'moto', 'bicicleta')->required(),
				'sinistro' => _Bool::new()->required(),
				'fipe' 	   => _Float::new()->min(0)->required(),
				// 'descricao_detalhada' => Type::$bigString,
				'donos' => [
					[
						'nome' 		=> _String::new()->max(10)->min(5)->required(),
						'posse_de'  => _Date::pattern('br')->required(),
						'posse_ate' => _Date::pattern('br')->required(),
					]
				]
			]
		]
	]);

	// $person->validate();
} catch (ValidatorException $e) {
	echo $e->getMessage();
}
