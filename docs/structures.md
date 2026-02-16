---
description: >-
  O SimpleValidator oferece três estruturas poderosas para validar dados
  complexos: Struct, Slice e Map.
icon: cubes
layout:
  width: default
  title:
    visible: true
  description:
    visible: true
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: true
  metadata:
    visible: true
  tags:
    visible: true
---

# Estruturas de Dados

### Introdução

O SimpleValidator oferece três estruturas poderosas para validar dados complexos:

| Estrutura  | Descrição                                                           | Caso de Uso                           |
| ---------- | ------------------------------------------------------------------- | ------------------------------------- |
| **Struct** | Valida objetos com chaves conhecidas                                | Formulários, corpos de requisição API |
| **Slice**  | Valida arrays indexados onde todos os itens seguem as mesmas regras | Listas de produtos, tags, IDs         |
| **Map**    | Valida pares chave-valor com chaves dinâmicas                       | Metadados, configurações, traduções   |

Essas estruturas podem ser aninhadas arbitrariamente para validar qualquer formato de dado que sua aplicação precisar.

### Struct

A `Struct` é a estrutura mais comumente usada. Ela valida um array associativo (objeto) onde as chaves são conhecidas antecipadamente.

#### Definindo uma Struct

{% tabs %}
{% tab title="Sintaxe String" %}
{% code fullWidth="false" %}
```php
use Lucasjs7\SimpleValidator\Struct;

$userValidator = Struct::new([
    'name'     => 'type: string | min: 2 | max: 100 | required',
    'email'    => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
    'age'      => 'type: int | min: 0 | max: 150',
    'nickname' => 'type: string | max: 50',
]);
```
{% endcode %}
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;

$userValidator = Struct::new([
    'name'     => _String::new()->min(2)->max(100)->required(),
    'email'    => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    'age'      => _Int::new()->min(0)->max(150),
    'nickname' => _String::new()->max(50),
]);
```
{% endtab %}
{% endtabs %}

Cada chave no array representa um nome de campo, e o valor define as regras de validação para esse campo.

#### Structs Aninhadas

Você pode aninhar Structs para validar objetos dentro de objetos:

{% tabs %}
{% tab title="Sintaxe String" %}
```php
$userValidator = Struct::new([
    'name'    => 'type: string | required',
    'email'   => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
    'address' => Struct::new([
        'street'  => 'type: string | max: 200 | required',
        'city'    => 'type: string | max: 100 | required',
        'zipcode' => 'type: string | regex: /^\d{5}-?\d{3}$/ | required',
        'country' => 'type: string | max: 2 | required',
    ]),
]);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
$userValidator = Struct::new([
    'name'    => _String::new()->required(),
    'email'   => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    'address' => Struct::new([
        'street'  => _String::new()->max(200)->required(),
        'city'    => _String::new()->max(100)->required(),
        'zipcode' => _String::new()->regex('/^\d{5}-?\d{3}$/')->required(),
        'country' => _String::new()->max(2)->required(),
    ]),
]);
```
{% endtab %}
{% endtabs %}

Isso valida dados como:

{% code title="Dados de exemplo" %}
```php
$userData = [
    'name'  => 'João Silva',
    'email' => 'joao@exemplo.com',
    'address' => [
        'street'  => 'Av. Paulista, 123',
        'city'    => 'São Paulo',
        'zipcode' => '01311-000',
        'country' => 'BR',
    ],
];
```
{% endcode %}

#### Validando com Struct

Use o método `validate()` para validar os dados:

{% code title="Validação" %}
```php
use Lucasjs7\SimpleValidator\ValidatorException;

try {
    $userValidator->validate($userData);
    echo "Dados válidos!";
} catch (ValidatorException $e) {
    echo "Erro: " . $e->getMessage();
    print_r($e->getErrorPath()); // Mostra o caminho para o campo com erro
}
```
{% endcode %}

### Slice

A `Slice` valida arrays indexados (listas) onde cada item deve seguir as mesmas regras de validação.

#### Definindo uma Slice

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Slice;

// Uma lista de inteiros positivos
$idsValidator = Slice::new(
    'type: int | unsigned | required'
);

// Uma lista de strings não vazias
$tagsValidator = Slice::new(
    'type: string | min: 1 | required'
);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Type\_Int;
use Lucasjs7\SimpleValidator\Type\_String;

// Uma lista de inteiros positivos
$idsValidator = Slice::new(
    _Int::new()->unsigned()->required()
);

// Uma lista de strings não vazias
$tagsValidator = Slice::new(
    _String::new()->min(1)->required()
);
```
{% endtab %}
{% endtabs %}

Isso valida dados como:

{% code title="Validação de Slice" %}
```php
$idsValidator->validate([1, 2, 3, 4, 5]);
$tagsValidator->validate(['php', 'laravel', 'validacao']);
```
{% endcode %}

#### Slice de Structs

Um padrão comum é validar uma lista de objetos:

{% tabs %}
{% tab title="Sintaxe String" %}
```php
$productsValidator = Slice::new(
    Struct::new([
        'id'    => 'type: int | required',
        'name'  => 'type: string | min: 1 | max: 200 | required',
        'price' => 'type: float | unsigned | required',
    ])
);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
$productsValidator = Slice::new(
    Struct::new([
        'id'    => _Int::new()->required(),
        'name'  => _String::new()->min(1)->max(200)->required(),
        'price' => _Float::new()->unsigned()->required(),
    ])
);
```
{% endtab %}
{% endtabs %}

Isso valida dados como:

{% code title="Dados de exemplo" %}
```php
$products = [
    ['id' => 1, 'name' => 'Widget', 'price' => 9.99],
    ['id' => 2, 'name' => 'Gadget', 'price' => 19.99],
    ['id' => 3, 'name' => 'Gizmo',  'price' => 29.99],
];

$productsValidator->validate($products);
```
{% endcode %}

### Map

O `Map` valida arrays associativos onde as chaves são dinâmicas (desconhecidas de antemão), mas tanto as chaves quanto os valores devem seguir regras específicas.

#### Definindo um Map

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Map;

// Chaves deve ser strings, valores devem ser inteiros
$scoresValidator = Map::new(
    'type: string',  // Regras para chave
    'type: int'      // Regras para valor
);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;

// Chaves deve ser strings, valores devem ser inteiros
$scoresValidator = Map::new(
    _String::new(),  // Regras para chave
    _Int::new()      // Regras para valor
);
```
{% endtab %}
{% endtabs %}

Isso valida dados como:

{% code title="Validação de Map" %}
```php
$scores = [
    'joao'  => 95,
    'maria' => 87,
    'bob'   => 92,
];

$scoresValidator->validate($scores);
```
{% endcode %}

#### Map com Valores Complexos

Valores de Map podem ser de qualquer tipo, incluindo Structs:

{% tabs %}
{% tab title="Sintaxe String" %}
```php
$settingsValidator = Map::new(
    'type: string | min: 1',         // Chave: string não vazia
    'type: interface | required'     // Valor: qualquer tipo, mas obrigatório (interface similar a mixed)
);

// Ou com valores Struct
$usersMapValidator = Map::new(
    'type: string',  // Chave: ID de usuário como string
    Struct::new([
        'name'  => 'type: string | required',
        'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
    ])
);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
$settingsValidator = Map::new(
    _String::new()->min(1),         // Chave: string não vazia
    _Interface::new()->required()   // Valor: qualquer tipo, mas obrigatório
);

// Ou com valores Struct
$usersMapValidator = Map::new(
    _String::new(),  // Chave: ID de usuário como string
    Struct::new([
        'name'  => _String::new()->required(),
        'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    ])
);
```
{% endtab %}
{% endtabs %}

### Combinando Estruturas

O verdadeiro poder do SimpleValidator vem da combinação dessas estruturas. Aqui está um exemplo complexo que valida um pedido de e-commerce:

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\{Struct, Slice, Map};

$orderValidator = Struct::new([
    'id'         => 'type: int | required',
    'created_at' => 'type: date | format: Y-m-d H:i:s | required',

    'customer' => Struct::new([
        'name'  => 'type: string | min: 2 | max: 100 | required',
        'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
        'phone' => 'type: string | regex: /^\+?[\d\s-]+$/',
    ]),

    'items' => Slice::new(
        Struct::new([
            'product_id'  => 'type: int | required',
            'name'        => 'type: string | max: 200 | required',
            'quantity'    => 'type: int | min: 1 | required',
            'unit_price'  => 'type: float | unsigned | required',
            'attributes'  => Map::new(
                'type: string',
                'type: string'
            ),
        ])
    ),

    'shipping' => Struct::new([
        'method'  => 'type: string | options: padrao, express, entrega_rapida | required',
        'address' => Struct::new([
            'street'  => 'type: string | max: 200 | required',
            'city'    => 'type: string | max: 100 | required',
            'state'   => 'type: string | max: 2 | required',
            'zipcode' => 'type: string | required',
            'country' => 'type: string | max: 2 | required',
        ]),
    ]),

    'notes' => 'type: string | max: 1000',
]);
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\{Struct, Slice, Map};
use Lucasjs7\SimpleValidator\Type\{_String, _Int, _Float, _Bool, _Date};

$orderValidator = Struct::new([
    'id'         => _Int::new()->required(),
    'created_at' => _Date::new()->format('Y-m-d H:i:s')->required(),

    'customer' => Struct::new([
        'name'  => _String::new()->min(2)->max(100)->required(),
        'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
        'phone' => _String::new()->regex('/^\+?[\d\s-]+$/'),
    ]),

    'items' => Slice::new(
        Struct::new([
            'product_id'  => _Int::new()->required(),
            'name'        => _String::new()->max(200)->required(),
            'quantity'    => _Int::new()->min(1)->required(),
            'unit_price'  => _Float::new()->unsigned()->required(),
            'attributes'  => Map::new(
                _String::new(),
                _String::new()
            ),
        ])
    ),

    'shipping' => Struct::new([
        'method'  => _String::new()->options('padrao', 'express', 'entrega_rapida')->required(),
        'address' => Struct::new([
            'street'  => _String::new()->max(200)->required(),
            'city'    => _String::new()->max(100)->required(),
            'state'   => _String::new()->max(2)->required(),
            'zipcode' => _String::new()->required(),
            'country' => _String::new()->max(2)->required(),
        ]),
    ]),

    'notes' => _String::new()->max(1000),
]);
```
{% endtab %}
{% endtabs %}

Este único validador pode verificar um objeto de pedido completo com informações aninhadas do cliente, uma lista de itens com atributos dinâmicos e detalhes de envio!
