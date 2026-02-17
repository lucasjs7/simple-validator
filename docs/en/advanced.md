---
description: >-
  Advanced features: Reusable patterns, Reflection-based validation,
  Type Parser, and Exception-less validation.
icon: gear-complex
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

# Advanced Features

### Introduction

This page covers advanced features of SimpleValidator that help you write cleaner and easier-to-maintain validation code.

### Reusable Patterns

If you find yourself using the same validation configuration repeatedly, you can save it as a named pattern and reuse it throughout your application.

#### Saving Patterns

Use the `save()` method to store a validation configuration:

{% code title="Saving Patterns" %}
```php
use Lucasjs7\SimpleValidator\Type\_Date;
use Lucasjs7\SimpleValidator\Type\_String;

// Save common date formats
_Date::new()->format('d/m/Y')->save('brazilian');
_Date::new()->format('Y-m-d')->save('iso');
_Date::new()->format('Y-m-d H:i:s')->save('datetime');

// Save a username pattern
_String::new()
    ->min(3)
    ->max(20)
    ->regex('/^[a-zA-Z0-9_]+$/')
    ->save('username');
```
{% endcode %}

> **Tip:** Save your patterns early in your application's bootstrapping process, such as in a Service Provider or configuration file.

#### Using Patterns

Use the `pattern()` method to retrieve a saved configuration:

{% code title="Using Patterns" %}
```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_Date;
use Lucasjs7\SimpleValidator\Type\_String;

$validator = Struct::new([
    'username'   => _String::pattern('username')->required(),
    'birth_date' => _Date::pattern('brazilian')->required(),
    'created_at' => _Date::pattern('datetime'),
]);
```
{% endcode %}

You can also use patterns in string syntax:

{% code title="Patterns in string syntax" %}
```php
$validator = Struct::new([
    'birth_date' => 'type: date | pattern: brazilian | required',
]);
```
{% endcode %}

### Reflection-Based Validation

The `StructParser` class can automatically create validators from your existing PHP code using Reflection. This eliminates the need to duplicate your field definitions.

#### From Class Constructor

Create a validator from a class constructor:

{% code title="Constructor Validation" %}
```php
use Lucasjs7\SimpleValidator\StructParser;

class User {
    public function __construct(
        public string $name,
        public string $email,
        public int $age,
        public ?string $bio = null
    ) {}
}

$validator = StructParser::new(User::class);

// Now validate data before instantiation
$data = ['name' => 'John', 'email' => 'john@example.com', 'age' => 25];
$validator->validate($data);

// If validation passes, create the object safely
$user = new User(...$data);
```
{% endcode %}

**How it works:**

* Required parameters become `required` fields
* Optional parameters (with default values) become optional fields
* Types are inferred from PHP type hints

#### From Method

Create a validator from any method's parameters:

{% code title="Method Validation" %}
```php
class OrderService {
    public function createOrder(
        int $userId,
        float $amount,
        string $currency,
        ?string $notes = null
    ) {
        // ...
    }
}

$validator = StructParser::method(OrderService::class, 'createOrder');

$data = [
    'userId'   => 123,
    'amount'   => 99.99,
    'currency' => 'USD',
];

$validator->validate($data);
```
{% endcode %}

#### From Function

Create a validator from a function:

{% code title="Function Validation" %}
```php
function processPayment(
    string $cardNumber,
    float $amount,
    bool $recurring = false
) {
    // ...
}

$validator = StructParser::function('processPayment');
```
{% endcode %}

#### Using PHP Attributes

For more control over validation rules, use the `#[TypeParser]` attribute on constructor parameters:

{% code title="PHP Attributes" %}
```php
use Lucasjs7\SimpleValidator\StructParser;
use Lucasjs7\SimpleValidator\Type\TypeParser;

class Product {
    public function __construct(
        #[TypeParser('type: string | min: 3 | max: 200')]
        public string $name,

        #[TypeParser('type: float | unsigned')]
        public float $price,

        #[TypeParser('type: string | options: active, draft, archived')]
        public string $status,

        #[TypeParser('type: string | max: 1000')]
        public ?string $description = null
    ) {}
}

$validator = StructParser::new(Product::class);
```
{% endcode %}

#### Using DocBlocks

Alternatively, you can use `@validate` annotations in property DocBlocks:

{% code title="DocBlocks" %}
```php
class Product {
    /**
     * @validate type: string | min: 3 | max: 200
     */
    public string $name;

    /**
     * @validate type: float | unsigned
     */
    public float $price;

    /**
     * @validate type: string | options: active, draft, archived
     */
    public string $status;

    public function __construct(
        string $name,
        float $price,
        string $status
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;
    }
}

$validator = StructParser::new(Product::class);
```
{% endcode %}

> **Note:** The `required` constraint is automatically determined based on whether the constructor parameter is optional. Parameters without default values are required.

### Exception-less Validation

By default, the `validate()` method throws a `ValidatorException` when validation fails. If you prefer to handle errors without exceptions, pass `false` as the second parameter:

{% code title="No Exception" %}
```php
use Lucasjs7\SimpleValidator\Struct;

$validator = Struct::new([
    'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
]);

$data = ['email' => ''];

// Returns false instead of throwing exception
if ($validator->validate(value: $data, exception: false)) {
    echo "Validation passed!";
} else {
    echo "Validation failed: " . $validator->getError();
}
```
{% endcode %}

This approach is useful when:

* You are validating multiple datasets and want to collect all errors
* You prefer a more procedural coding style
* You are integrating with code that doesn't use exceptions

### Getting Validator Information

The `info()` method returns a string representation of a validator's rules. This is useful for debugging or generating documentation:

{% code title="Validator Info" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;

$validator = _String::new()
    ->min(3)
    ->max(100)
    ->required();

echo $validator->info();
// Output: "type: string | min: 3 | max: 100 | required: true"
```
{% endcode %}

For structures (`Struct`), `info()` returns an array:

{% code title="Struct Info" %}
```php
use Lucasjs7\SimpleValidator\Struct;

$validator = Struct::new([
    'name'  => 'type: string | required',
    'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/',
]);

print_r($validator->info());
// Output:
// Array
// (
//     [name] => type: string | required: true
//     [email] => type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/
// )
```
{% endcode %}
