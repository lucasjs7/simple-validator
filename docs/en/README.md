---
description: >-
  A lightweight and fluent PHP validation library covering nested data structures
  (Struct, Slice, Map) and reflection-based validation.
icon: sparkle
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

# Getting Started

### Meet SimpleValidator

SimpleValidator is a lightweight and flexible data validation library for PHP.

It allows validating complex data structures, such as nested arrays, JSON APIs, and forms, using an expressive fluent syntax or string-based definitions.

Whether building a simple contact form or validating complex API payloads with nested objects and arrays, SimpleValidator provides powerful tools to ensure your data meets your application's requirements.

#### Why SimpleValidator?

There are several reasons why SimpleValidator might be the right choice for your project:

**Expressive Syntax**

SimpleValidator lets you define validation rules clearly and readably.

You can use the fluent API with method chaining or an easy-to-store and configure string-based syntax:

{% code title="Example (fluent vs string)" %}
```php
// Fluent Syntax
_String::new()->min(3)->max(100)->required()

// String Syntax
'type: string | min: 3 | max: 100 | required'
```
{% endcode %}

**Nested Data Structures**

Unlike many validation libraries, SimpleValidator was built from the ground up to handle nested data.

It provides three powerful structures: `Struct`, `Slice`, and `Map` that can be combined to validate any data format.

{% code title="Validation with Struct, Slice, and Map" %}
```php
use Lucasjs7\SimpleValidator\{Struct, Slice, Map};
use Lucasjs7\SimpleValidator\Type\{_String, _Int};

$validator = Struct::new([
    // Struct: Nested object
    'user' => Struct::new([
        'name' => _String::new()->required(),
    ]),

    // Slice: List of strings
    'tags' => Slice::new(
        _String::new()->min(3)
    ),

    // Map: Dynamic keys
    'settings' => Map::new(
        _String::new(), // Key (string)
        _Int::new()     // Value (int)
    ),
]);
```
{% endcode %}

**Reflection Coverage**

SimpleValidator can automatically create validators from your existing PHP classes using Reflection.

No need to duplicate your validation rules - just annotate constructor parameters or properties.

{% code title="Generating validator with StructParser" %}
```php
use Lucasjs7\SimpleValidator\StructParser;

class UserDTO {
    public function __construct(
        public string $name,
        public string $email,
    ) {
        // ...
    }
}

$validator = StructParser::new(UserDTO::class);
```
{% endcode %}

### Next Steps

Now that you've installed SimpleValidator, you might want to learn more about:

* [**Quick Start**](quickstart.md) - Learn the basics with complete examples
* [**Data Structures**](structures.md) - Understand Struct, Slice, and Map
* [**Available Types**](types.md) - Explore all validation types
* [**Available Rules**](rules.md) - Learn about rules like min, max, regex

### License

SimpleValidator is open-source software licensed under the MIT license.
