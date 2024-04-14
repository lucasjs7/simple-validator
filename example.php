<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

// use Lib\SimpleValidator\Struct;
use Lib\SimpleValidator\Type\_String;
use Lib\SimpleValidator\Type\TypeException;

try {

	$vString = (new _String)->min(3)->max(2);

	var_dump($vString->validate(3));
} catch (TypeException $e) {
	echo "Error: {$e->getMessage()}";
}

// try {
// 	Struct::new([
// 		'nome' 		=> Type::$string->max(10)->min(5)->required(),
// 		'sobrenome' => Type::$string->max(16)->min(4),
// 		'idade' 	=> Type::$int->max(1)->min(2)->required(),
// 		'veiculos'  => [
// 			[
// 				'tipo' 	   			  => Type::$string->options('carro', 'moto', 'bicicleta')->required(),
// 				'sinistro' 			  => Type::$bool->required(),
// 				'descricao_detalhada' => Type::$bigString,
// 				'donos' => [
// 					[
// 						'nome' 		=> Type::$string->max(10)->min(5)->required(),
// 						'posse_de'  => Type::$date->format('d-m-Y')->required(),
// 						'posse_ate' => Type::$date->format('d-m-Y')->required(),
// 					]
// 				]
// 			]
// 		]
// 	]);

// 	echo 'sucesso';
// } catch (\Exception $e) {
// 	echo $e->getMessage();
// }
