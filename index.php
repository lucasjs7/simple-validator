<?php

ini_set('display_errors', '1');

include 'Validator\Fields\GroupFields.php';
include 'Validator\Fields\Field.php';
include 'Validator\Fields\ExceptionField.php';

use Validator\Fields\GroupFields as vFields;
use Validator\Fields\ExceptionField;

try {
	$vFields = new vFields([], true);
	$vFields->addAll([
		'name_teste' => [
			'required' => true,
			'type' 	   => 'string',
		]
	]);

	$vFields->validate();

	var_dump($vFields);

	echo 'sucesso';
} catch (ExceptionField $e) {
	echo $e->getMessage();
}
