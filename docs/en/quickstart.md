---
description: >-
  A quick guide to start validating data with SimpleValidator.
icon: rabbit-running
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

# Quick Start

### Introduction

SimpleValidator offers a powerful and expressive way to validate data in your PHP applications. Whether validating form input, API payloads, or configuration data, SimpleValidator has you covered.

In this quick guide, we will walk through a complete example of validating user input and handling validation errors. By the end, you will have a solid understanding of how SimpleValidator works.

### Quick Start

Let's build a complete example validating a user registration form with name, email, and age.

#### Defining a Validator

First, we create a validator that describes the expected data structure:

{% code title="Defining Validator" %}
```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;

$validator = Struct::new([
    'name'  => _String::new()->min(3)->max(100)->required(),
    'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    'age'   => _Int::new()->min(18)->max(120)->required(),
]);
```
{% endcode %}

In this example:

* `name` must be a string between 3 and 100 characters, and is required
* `email` must be a valid email address, and is required
* `age` must be an integer between 18 and 120, and is required

#### Validating Data

Now let's validate some input data. The `validate` method will throw a `ValidatorException` if validation fails:

{% code title="Validating Data" %}
```php
use Lucasjs7\SimpleValidator\ValidatorException;

$userData = [
    'name'  => 'John Doe',
    'email' => 'john@example.com',
    'age'   => 25,
];

try {
    $validator->validate($userData);

    // Validation passed! Continue with your logic...
    echo "User data valid!";

} catch (ValidatorException $e) {
    // Validation failed
    echo "Validation error: " . $e->getMessage();
}
```
{% endcode %}

If validation passes, execution continues normally. If it fails, a `ValidatorException` is thrown with a descriptive error message.

#### Displaying Validation Errors

The `ValidatorException` provides useful information about what went wrong:

{% code title="Error Handling" %}
```php
try {
    $validator->validate($invalidData);
} catch (ValidatorException $e) {
    // Get the error message
    $message = $e->getMessage();
    // Example: "The value must have at least 3 characters (path: name)."

    // Get the path of the failed field
    $errorPath = $e->getErrorPath();
    // Example: ['name']

    // For nested structures, variable path shows full location
    // Example: ['users', 0, 'address', 'zipcode']
}
```
{% endcode %}

> **Tip:** You can also use the `debug()` method during development to get detailed error output:

{% code title="Debug" %}
```php
$e->debug(); // Prints formatted error info and exits execution
```
{% endcode %}

### A Note on Optional Fields

By default, all fields are **optional**. If a field is not present in the input data, validation will pass.

However, if the field is provided, it must obey validaton rules.

{% code title="Optional Fields" %}
```php
$validator = Struct::new([
    'nickname' => _String::new()->max(6),
]);

$validator->validate([]); // Valid
$validator->validate(['nickname' => 'Name']); // Valid
$validator->validate(['nickname' => null]); // Invalid
$validator->validate(['nickname' => 'TooLongName']); // Invalid
```
{% endcode %}

To make a field required, use the `required()` method:

{% code title="Required Field" %}
```php
$validator = Struct::new([
    'nickname' => _String::new()->max(50)->required(), // Now required!
]);

// This now throws an exception
$validator->validate([]);
```
{% endcode %}

### Two Syntax Options

SimpleValidator offers two ways to define validation rules. You can use whichever feels more natural for your use case, or mix them as needed.

#### Fluent Syntax

Fluent syntax uses PHP classes and method chaining:

{% code title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;
use Lucasjs7\SimpleValidator\Type\_Date;

$validator = Struct::new([
    'title'       => _String::new()->min(5)->max(200)->required(),
    'description' => _String::new()->max(1000),
    'views'       => _Int::new()->unsigned(),
    'published'   => _Date::new()->format('Y-m-d'),
]);
```
{% endcode %}

**Benefits:**

* Full IDE autocomplete
* Type checking
* Easy discovery of available methods

#### String Syntax

String syntax uses pipe-delimited strings (`|`):

{% code title="String Syntax" %}
```php
$validator = Struct::new([
    'title'       => 'type: string | min: 5 | max: 200 | required',
    'description' => 'type: string | max: 1000',
    'views'       => 'type: int | unsigned',
    'published'   => 'type: date | format: Y-m-d',
]);
```
{% endcode %}

**Benefits:**

* Easy to store in config files or database
* More concise for simple validations
* Familiar if you've used Laravel validation

Both syntaxes are fully interchangeable and can be mixed in the same `Struct`:

{% code title="Mixed Syntax" %}
```php
$validator = Struct::new([
    'title' => _String::new()->min(5)->required(),  // Fluent
    'views' => 'type: int | unsigned',              // String
]);
```
{% endcode %}
