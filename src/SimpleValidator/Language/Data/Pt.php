<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class Pt extends Data {

	public static function get(): array {
		return [
			'type' => [
				'desc-type-string' => 'texto',
				'desc-type-int' => 'numérico, sem decimais',
				'desc-type-float' => 'numérico, com decimais',
				'desc-type-date' => 'data',
				'desc-type-bool' => 'verdadeiro ou falso',
				'type-base' => [
					'error-required' => 'Este campo é obrigatório.',
					'error-type' => 'O valor deve ser do tipo {{type}}.',
					'error-attr-conflict' => 'Estão sendo usados atributos conflitantes.',
				],
				'attribute' => [
					'unsigned' => [
						'error-invalid' => 'O valor não pode ser inferior a zero.'
					],
					'regex' => [
						'error-invalid' => 'O valor deve estar no seguinte formato {{value}}.',
						'error-pattern' => 'O padrão regex usado é inválido.',
					],
					'options' => [
						'error-invalid' => 'O valor não está dentro das opções esperadas.',
					],
					'min' => [
						'error-invalid' => 'O valor deve ser igual ou superior a {{value}}.',
						'error-max' => 'O atributo "min" não pode ser superior ao atributo "max".',
					],
					'max' => [
						'error-invalid' => 'O valor deve ser igual ou inferior a {{value}}.',
					],
					'format' => [
						'error-invalid' => 'O valor deve estar no seguinte formato {{value}}.',
					],
				],
			],
			'map' => [
				'error-key-value' => 'O valor deve conter uma estrutura chave-valor.',
				'error-prefix-key' => 'Erro na chave: ',
				'error-prefix-value' => 'Erro no valor: ',
			],
			'slice' => [
				'error-list' => 'O valor deve conter uma lista.',
				'error-prefix-key' => 'Erro no valor: ',
			],
			'struct' => [
				'error-data' => 'A Struct só pode conter classes filhas de DataStructure ou TypeBase.',
				'error-list' => 'O valor deve conter uma estrutura chave-valor.',
				'error-prefix-key' => 'Erro na chave: ',
				'error-prefix-value' => 'Erro no valor: ',
			],
			'exception' => [
				'debug' => 'Debug',
			],
		];
	}
}
