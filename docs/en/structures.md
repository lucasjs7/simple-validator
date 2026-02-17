---
description: >-
  SimpleValidator offers three powerful structures for validating complex data:
  Struct, Slice, and Map.
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

# Data Structures

### Introduction

SimpleValidator offers three powerful structures for validating complex data:

| Structure  | Description                                                         | Use Case                              |
| ---------- | ------------------------------------------------------------------- | ------------------------------------- |
| **Struct** | Validates objects with known keys                                   | Forms, API request bodies             |
| **Slice**  | Validates indexed arrays where all items follow the same rules      | Lists of products, tags, IDs          |
| **Map**    | Validates key-value pairs with dynamic keys                         | Metadata, settings, translations      |

These structures can be arbitrarily nested to validate any data format your application needs.

### Struct

`Struct` is the most commonly used structure. It validates an associative array (object) where keys are known in advance.

#### Defining a Struct

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Struct;

$userValidator = Struct::new([
    'name'     => 'type: string | min: 2 | max: 100 | required',
    'email'    => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
    'age'      => 'type: int | min: 0 | max: 150',
    'nickname' => 'type: string | max: 50',
]);
```
{% endtab %}

{% tab title="Fluent Syntax" %}
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

Each key in the array represents a field name, and the value defines the validation rules for that field.

#### Nested Structs

You can nest Structs to validate objects inside objects:

{% tabs %}
{% tab title="String Syntax" %}
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

{% tab title="Fluent Syntax" %}
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

This validates data like:

{% code title="Example data" %}
```php
$userData = [
    'name'  => 'John Doe',
    'email' => 'john@example.com',
    'address' => [
        'street'  => 'Main Street, 123',
        'city'    => 'New York',
        'zipcode' => '10001',
        'country' => 'US',
    ],
];
```
{% endcode %}

#### Validating with Struct

Use the `validate()` method to validate data:

{% code title="Validation" %}
```php
use Lucasjs7\SimpleValidator\ValidatorException;

try {
    $userValidator->validate($userData);
    echo "Valid data!";
} catch (ValidatorException $e) {
    echo "Error: " . $e->getMessage();
    print_r($e->getErrorPath()); // Shows the path to the error field
}
```
{% endcode %}

### Slice

`Slice` validates indexed arrays (lists) where each item must follow the same validation rules.

#### Defining a Slice

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Slice;

// A list of positive integers
$idsValidator = Slice::new(
    'type: int | unsigned | required'
);

// A list of non-empty strings
$tagsValidator = Slice::new(
    'type: string | min: 1 | required'
);
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Slice;
use Lucasjs7\SimpleValidator\Type\_Int;
use Lucasjs7\SimpleValidator\Type\_String;

// A list of positive integers
$idsValidator = Slice::new(
    _Int::new()->unsigned()->required()
);

// A list of non-empty strings
$tagsValidator = Slice::new(
    _String::new()->min(1)->required()
);
```
{% endtab %}
{% endtabs %}

This validates data like:

{% code title="Slice Validation" %}
```php
$idsValidator->validate([1, 2, 3, 4, 5]);
$tagsValidator->validate(['php', 'laravel', 'validation']);
```
{% endcode %}

#### Slice of Structs

A common pattern is validating a list of objects:

{% tabs %}
{% tab title="String Syntax" %}
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

{% tab title="Fluent Syntax" %}
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

This validates data like:

{% code title="Example data" %}
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

`Map` validates associative arrays where keys are dynamic (unknown beforehand), but both keys and values must follow specific rules.

#### Defining a Map

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Map;

// Keys must be strings, values must be integers
$scoresValidator = Map::new(
    'type: string',  // Rules for key
    'type: int'      // Rules for value
);
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Map;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;

// Keys must be strings, values must be integers
$scoresValidator = Map::new(
    _String::new(),  // Rules for key
    _Int::new()      // Rules for value
);
```
{% endtab %}
{% endtabs %}

This validates data like:

{% code title="Map Validation" %}
```php
$scores = [
    'john'  => 95,
    'mary'  => 87,
    'bob'   => 92,
];

$scoresValidator->validate($scores);
```
{% endcode %}

#### Map with Complex Values

Map values can be of any type, including Structs:

{% tabs %}
{% tab title="String Syntax" %}
```php
$settingsValidator = Map::new(
    'type: string | min: 1',         // Key: non-empty string
    'type: interface | required'     // Value: any type, but required (interface similar to mixed)
);

// Or with Struct values
$usersMapValidator = Map::new(
    'type: string',  // Key: User ID as string
    Struct::new([
        'name'  => 'type: string | required',
        'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
    ])
);
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
$settingsValidator = Map::new(
    _String::new()->min(1),         // Key: non-empty string
    _Interface::new()->required()   // Value: any type, but required
);

// Or with Struct values
$usersMapValidator = Map::new(
    _String::new(),  // Key: User ID as string
    Struct::new([
        'name'  => _String::new()->required(),
        'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    ])
);
```
{% endtab %}
{% endtabs %}

### Combining Structures

The true power of SimpleValidator comes from combining these structures. Here is a complex example validating an e-commerce order:

{% tabs %}
{% tab title="String Syntax" %}
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
        'method'  => 'type: string | options: standard, express, next_day | required',
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

{% tab title="Fluent Syntax" %}
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
        'method'  => _String::new()->options('standard', 'express', 'next_day')->required(),
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

This single validator can check a complete order object with nested customer info, a list of items with dynamic attributes, and shipping details!
