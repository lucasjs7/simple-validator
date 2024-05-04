<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class En extends Data {

    public static function get(): array {
        return [
            'type' => [
                'desc-type-string' => 'text',
                'desc-type-int' => 'numeric, no decimals',
                'desc-type-float' => 'numeric, with decimals',
                'desc-type-date' => 'date',
                'desc-type-bool' => 'true or false',
                'type-base' => [
                    'error-required' => 'This field is required.',
                    'error-type' => 'The value must be of type {{type}}.',
                    'error-attr-conflict' => 'Conflicting attributes are being used.',
                ],
                'attribute' => [
                    'unsigned' => [
                        'error-invalid' => 'The value cannot be less than zero.'
                    ],
                    'regex' => [
                        'error-invalid' => 'The value must be in the following format {{value}}.',
                        'error-pattern' => 'The regex pattern used is invalid.',
                    ],
                    'options' => [
                        'error-invalid' => 'The value is not within the expected options.',
                    ],
                    'min' => [
                        'error-invalid' => 'The value must be equal to or greater than {{value}}.',
                        'error-max' => 'The "min" attribute cannot be greater than the "max" attribute.',
                    ],
                    'max' => [
                        'error-invalid' => 'The value must be equal to or less than {{value}}.',
                    ],
                    'format' => [
                        'error-invalid' => 'The value must be in the following format {{value}}.',
                    ],
                ],
            ],
            'map' => [
                'error-key-value' => 'The value must contain a key-value structure.',
                'error-prefix-key' => 'Key error: ',
                'error-prefix-value' => 'Error in value: ',
            ],
            'slice' => [
                'error-list' => 'The value must contain a list.',
                'error-prefix-key' => 'Error in value: ',
            ],
            'struct' => [
                'error-data' => 'A Struct can only contain child classes of DataStructure or TypeBase.',
                'error-list' => 'The value must contain a key-value structure.',
                'error-prefix-key' => 'Key error: ',
                'error-prefix-value' => 'Error in value: ',
            ],
            'exception' => [
                'debug' => 'Debug',
            ],
        ];
    }
}
