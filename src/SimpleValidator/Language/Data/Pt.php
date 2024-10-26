<?php

namespace Lucasjs7\SimpleValidator\Language\Data;

class Pt extends Data {

    public static function get(): array {
        return [
            'path' => 'diretório',
            'field' => 'campo',
            'type' => [
                'prefix_key' => 'Erro na chave: ',
                'prefix_value' => 'Erro no valor: ',
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
                'parser' => [
                    'required' => 'O parâmetro "type" é obrigatório.',
                    'value' => 'Não foi atribuído valor ao parâmetro "type".',
                    'not_exists' => 'Não foi encontrado o tipo {{type}}.',
                    'param' => 'O parâmetro {{param}} não existe.',
                ],
                'pattern' => [
                    'not_exists' => 'O pattern \'{{name}}\' do tipo \'{{type}}\' não existe.',
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
                        'invalid' => [
                            'string' => 'O texto deve ter no mínimo {{value}} caracteres.',
                            'number' => 'O valor deve ser igual ou superior a {{value}}.',
                        ],
                        'greater' => 'O atributo "min" não pode ser superior ao atributo "max".',
                    ],
                    'max' => [
                        'invalid' => 'O valor deve ser igual ou inferior a {{value}}.',
                    ],
                    'format' => [
                        'invalid' => 'O valor deve estar no seguinte formato {{value}}.',
                    ],
                    'callable' => [
                        'invalid' => 'O valor é inválido.',
                    ],
                ],
            ],
            'map' => [
                'key_value' => 'O conteúdo deve ser uma estrutura chave-valor.',
            ],
            'slice' => [
                'list' => 'O valor deve conter uma lista.',
            ],
            'struct' => [
                'key' => 'As chaves da struct devem ser do tipo string.',
                'data' => 'A Struct só pode conter classes filhas de DataStructure ou TypeBase.',
                'list' => 'O conteúdo deve ser uma estrutura chave-valor.',
            ],
            'exception' => [
                'debug' => 'Debug',
            ],
        ];
    }
}
