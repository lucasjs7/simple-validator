<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class En extends Data {

	public static function get(): array {
		return [
			'type' => [
				'type-base' => [
					'error-required' => '',
					'error-type' => '',
					'error-attr-conflict' => '',
				],
				'attribute' => [
					'unsigned' => [
						'error-invalid' => '',
					],
					'regex' => [
						'error-invalid' => '',
						'error-pattern' => '',
					],
					'options' => [
						'error-invalid' => '',
					],
					'min' => [
						'error-invalid' => '',
						'error-max' => '',
					],
					'max' => [
						'error-invalid' => '',
					],
					'format' => [
						'error-invalid' => '',
					]
				],
			],
			'map' => [
				'error-key-value' => '',
				'error-prefix-key' => '',
				'error-prefix-value' => '',
			],
			'slice' => [
				'error-list' => '',
				'error-prefix-key' => '',
			],
			'struct' => [
				'error-data' => '',
				'error-list' => '',
				'error-prefix-key' => '',
				'error-prefix-value' => '',
			],
			'exception' => [
				'debug' => '',
			],
		];
	}
}
