<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class Pt extends Data {

    public static function get(): array {
        return [
            'type' => [
                'desc_type_string' => 'texto',
                'desc_type_int' => 'numérico, sem decimais',
                'desc_type_float' => 'numérico, com decimais',
                'desc_type_date' => 'data',
                'desc_type_bool' => 'verdadeiro ou falso',
                'type_base' => [
                    'required' => 'Este campo é obrigatório.',
                    'type' => 'O valor deve ser do tipo {{type}}.',
                    'conflict' => 'Estão sendo usados atributos conflitantes.',
                ],
                'attribute' => [
                    'unsigned' => [
                        'invalid' => 'O valor não pode ser inferior a zero.'
                    ],
                    'regex' => [
                        'invalid' => 'O valor deve estar no seguinte formato {{value}}.',
                        'pattern' => 'O padrão regex usado é inválido.',
                    ],
                    'options' => [
                        'invalid' => 'O valor não está dentro das opções esperadas.',
                    ],
                    'min' => [
                        'invalid' => 'O valor deve ser igual ou superior a {{value}}.',
                        'greater' => 'O atributo "min" não pode ser superior ao atributo "max".',
                    ],
                    'max' => [
                        'invalid' => 'O valor deve ser igual ou inferior a {{value}}.',
                    ],
                    'format' => [
                        'invalid' => 'O valor deve estar no seguinte formato {{value}}.',
                    ],
                ],
            ],
            'map' => [
                'key_value' => 'O valor deve conter uma estrutura chave-valor.',
                'prefix_key' => 'Erro na chave: ',
                'prefix_value' => 'Erro no valor: ',
            ],
            'slice' => [
                'list' => 'O valor deve conter uma lista.',
                'prefix_key' => 'Erro no valor: ',
            ],
            'struct' => [
                'data' => 'A Struct só pode conter classes filhas de DataStructure ou TypeBase.',
                'list' => 'O valor deve conter uma estrutura chave-valor.',
                'prefix_key' => 'Erro na chave: ',
                'prefix_value' => 'Erro no valor: ',
            ],
            'exception' => [
                'debug' => 'Debug',
            ],
        ];
    }
}
