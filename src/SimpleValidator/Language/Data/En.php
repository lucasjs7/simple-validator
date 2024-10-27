<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class En extends Data {

    public static function get(): array {
        return [
            'path' => 'path',
            'field' => 'The following error occurred in field "{{label}}":',
            'type' => [
                'prefix_key' => 'Key error: ',
                'prefix_value' => 'Error in value: ',
                'desc_type_string' => 'text',
                'desc_type_int' => 'numeric, no decimals',
                'desc_type_float' => 'numeric, with decimals',
                'desc_type_date' => 'date',
                'desc_type_bool' => 'true or false',
                'type_base' => [
                    'required' => 'This field is required.',
                    'type' => 'The value must be of type {{type}}.',
                    'conflict' => 'Conflicting attributes are being used.',
                ],
                'parser' => [
                    'required' => 'The "type" parameter is mandatory.',
                    'value' => 'No value was assigned to the "type" parameter.',
                    'not_exists' => 'Type {{type}} not found.',
                    'param' => 'Parameter {{param}} does not exist.',
                ],
                'pattern' => [
                    'not_exists' => 'Pattern \'{{name}}\' of type \'{{type}}\' does not exist.',
                ],
                'attribute' => [
                    'unsigned' => [
                        'invalid' => 'The value cannot be less than zero.'
                    ],
                    'regex' => [
                        'invalid' => 'The value must be in the following format {{value}}.',
                        'pattern' => 'The regex pattern used is invalid.',
                    ],
                    'options' => [
                        'invalid' => 'The value is not within the expected options.',
                    ],
                    'min' => [
                        'invalid' => [
                            'string' => 'The text must have at least {{value}} characters.',
                            'number' => 'The value must be equal to or greater than {{value}}.',
                        ],
                        'greater' => 'The "min" attribute cannot be greater than the "max" attribute.',
                    ],
                    'max' => [
                        'invalid' => 'The value must be equal to or less than {{value}}.',
                    ],
                    'format' => [
                        'invalid' => 'The value must be in the following format {{value}}.',
                    ],
                    'callable' => [
                        'invalid' => 'The value is invalid.',
                        'empty' => 'No function has been assigned to _Callable.',
                        'anonymous' => 'The function assigned to _Callable must be anonymous.',
                    ],
                ],
            ],
            'map' => [
                'key_value' => 'Content should be a key-value structure.',
            ],
            'slice' => [
                'list' => 'The value must contain a list.',
            ],
            'struct' => [
                'key' => 'Struct keys must be of string type.',
                'data' => 'A Struct can only contain child classes of DataStructure or TypeBase.',
                'list' => 'Content should be a key-value structure.',
            ],
            'exception' => [
                'debug' => 'Debug',
            ],
        ];
    }
}
