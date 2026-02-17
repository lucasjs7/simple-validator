---
description: >-
  SimpleValidator offers a variety of types for data validation:
  String, Int, Float, Bool, Date, File, Image, Mixed, etc.
icon: list-check
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

# Available Types

### Introduction

SimpleValidator provides a variety of types to validate different kinds of data. Each type is a class in the `Lucasjs7\SimpleValidator\Type` namespace.

All types share some common methods:

| Method                         | Description                                            |
| ------------------------------ | ------------------------------------------------------ |
| `new(?string $label)`          | Creates a new instance with an optional label for error messages |
| `required(bool $value = true)` | Makes the field required                               |
| `label(string $value)`         | Sets a readable name for error messages                |
| `info()`                       | Returns a string representation of validation rules    |

### String Types

#### String

The `_String` type validates if a value is a string.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: string');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;

$validator = _String::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

| Method                       | Description                                   | Example                         |
| ---------------------------- | --------------------------------------------- | ------------------------------- |
| `min(int $length)`           | Minimum character length                      | `->min(3)`                      |
| `max(int $length)`           | Maximum character length                      | `->max(100)`                    |
| `options(string ...$values)` | Value must be one of the provided options     | `->options('active', 'inactive')` |
| `regex(string $pattern)`     | Value must match the regular expression       | `->regex('/^[a-z]+$/')`         |

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Username: 3-20 alphanumeric characters
$username = TypeParser::new('type: string | label: Username | min: 3 | max: 20 | regex: /^[a-zA-Z0-9_]+$/ | required');

// Status: must be one of options
$status = TypeParser::new('type: string | options: pending, approved, rejected | required');

// Bio: optional, max 500 characters
$bio = TypeParser::new('type: string | max: 500');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Username: 3-20 alphanumeric characters
$username = _String::new('Username')->min(3)->max(20)->regex('/^[a-zA-Z0-9_]+$/')->required();

// Status: must be one of options
$status = _String::new()->options('pending', 'approved', 'rejected')->required();

// Bio: optional, max 500 characters
$bio = _String::new()->max(500);
```
{% endtab %}
{% endtabs %}

### Numeric Types

#### Int

The `_Int` type validates if a value is an integer.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: int');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Int;

$validator = _Int::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

| Method            | Description                     | Example        |
| ----------------- | ------------------------------- | -------------- |
| `min(int $value)` | Minimum numeric value           | `->min(0)`     |
| `max(int $value)` | Maximum numeric value           | `->max(100)`   |
| `unsigned()`      | Value must be positive (> 0)    | `->unsigned()` |

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Age: 0 to 150
$age = TypeParser::new('type: int | label: Age | min: 0 | max: 150 | required');

// Quantity: positive integer
$quantity = TypeParser::new('type: int | unsigned | required');

// Score: -100 to 100
$score = TypeParser::new('type: int | min: -100 | max: 100');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Age: 0 to 150
$age = _Int::new('Age')->min(0)->max(150)->required();

// Quantity: positive integer
$quantity = _Int::new()->unsigned()->required();

// Score: -100 to 100
$score = _Int::new()->min(-100)->max(100);
```
{% endtab %}
{% endtabs %}

#### Float

The `_Float` type validates if a value is a floating-point number.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: float');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Float;

$validator = _Float::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

| Method              | Description                     | Example        |
| ------------------- | ------------------------------- | -------------- |
| `min(float $value)` | Minimum numeric value           | `->min(0.0)`   |
| `max(float $value)` | Maximum numeric value           | `->max(99.99)` |
| `unsigned()`        | Value must be positive (> 0)    | `->unsigned()` |

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Price: positive number
$price = TypeParser::new('type: float | label: Price | unsigned | required');

// Rating: 0.0 to 5.0
$rating = TypeParser::new('type: float | min: 0.0 | max: 5.0');

// Temperature: can be negative
$temperature = TypeParser::new('type: float | min: -50.0 | max: 50.0');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Price: positive number
$price = _Float::new('Price')->unsigned()->required();

// Rating: 0.0 to 5.0
$rating = _Float::new()->min(0.0)->max(5.0);

// Temperature: can be negative
$temperature = _Float::new()->min(-50.0)->max(50.0);
```
{% endtab %}
{% endtabs %}

### Boolean Types

#### Bool

The `_Bool` type validates if a value is boolean.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: bool');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Bool;

$validator = _Bool::new();
```
{% endtab %}
{% endtabs %}

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Terms of Service: required
$termsAccepted = TypeParser::new('type: bool | label: Terms | required');

// Receive Notifications: optional
$notifications = TypeParser::new('type: bool');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Terms of Service: required
$termsAccepted = _Bool::new('Terms')->required();

// Receive Notifications: optional
$notifications = _Bool::new();
```
{% endtab %}
{% endtabs %}

### Date Types

#### Date

The `_Date` type validates if a value is a string matching a date format.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: date');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Date;

$validator = _Date::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

| Method                   | Description                                 | Example             |
| ------------------------ | ------------------------------------------- | ------------------- |
| `format(string $format)` | Expected date format (PHP date format)      | `->format('Y-m-d')` |

The default format is `Y-m-d`.

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Birth Date: format YYYY-MM-DD
$birthDate = TypeParser::new('type: date | label: Birth Date | format: Y-m-d | required');

// Created At: datetime format
$createdAt = TypeParser::new('type: date | format: Y-m-d H:i:s | required');

// Brazilian date format
$brDate = TypeParser::new('type: date | format: d/m/Y');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Birth Date: format YYYY-MM-DD
$birthDate = _Date::new('Birth Date')->format('Y-m-d')->required();

// Created At: datetime format
$createdAt = _Date::new()->format('Y-m-d H:i:s')->required();

// Brazilian date format
$brDate = _Date::new()->format('d/m/Y');
```
{% endtab %}
{% endtabs %}

### File Types

#### File

The `_File` type validates uploaded files (expects PHP's `$_FILES` format).

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: file');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_File;

$validator = _File::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

| Method                       | Description                     | Example                |
| ---------------------------- | ------------------------------- | ---------------------- |
| `ext(string ...$extensions)` | Allowed file extensions         | `->ext('pdf', 'docx')` |
| `max(string $size)`          | Maximum file size               | `->max('5MB')`         |

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Only PDF documents, max 10MB
$document = TypeParser::new('type: file | label: Document | ext: pdf | max: 10MB | required');

// Multiple extensions allowed
$attachment = TypeParser::new('type: file | ext: pdf, doc, docx, txt | max: 5MB');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Only PDF documents, max 10MB
$document = _File::new('Document')->ext('pdf')->max('10MB')->required();

// Multiple extensions allowed
$attachment = _File::new()->ext('pdf', 'doc', 'docx', 'txt')->max('5MB');
```
{% endtab %}
{% endtabs %}

> **Note:** The `_File` type expects data in PHP's `$_FILES` format with keys: `name`, `type`, `size`, `tmp_name`, `full_path`, and `error`.

#### Image

The `_Image` type extends `_File` with specific validations for images.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: image');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Image;

$validator = _Image::new();
```
{% endtab %}
{% endtabs %}

**Available Rules**

Inherits all rules from `_File`, plus:

| Method                   | Description              | Example          |
| ------------------------ | ------------------------ | ---------------- |
| `width(int $maxWidth)`   | Maximum width in pixels  | `->width(1920)`  |
| `height(int $maxHeight)` | Maximum height in pixels | `->height(1080)` |

**Examples**

{% tabs %}
{% tab title="String Syntax" %}
```php
// Avatar: JPEG/PNG, max 2MB, max 500x500
$avatar = TypeParser::new('type: image | label: Avatar | ext: jpg, jpeg, png | max: 2MB | width: 500 | height: 500 | required');

// Hero Image: larger dimensions allowed
$heroImage = TypeParser::new('type: image | ext: jpg, png, webp | max: 5MB | width: 1920 | height: 1080');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// Avatar: JPEG/PNG, max 2MB, max 500x500
$avatar = _Image::new('Avatar')->ext('jpg', 'jpeg', 'png')->max('2MB')->width(500)->height(500)->required();

// Hero Image: larger dimensions allowed
$heroImage = _Image::new()->ext('jpg', 'png', 'webp')->max('5MB')->width(1920)->height(1080);
```
{% endtab %}
{% endtabs %}

### Special Types

#### Mixed

The `_Mixed` type accepts any value. Useful for fields where you only care about presence, not type.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$anyValue = TypeParser::new('type: mixed | required');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Mixed;

$anyValue = _Mixed::new()->required();
```
{% endtab %}
{% endtabs %}

#### Interface

The `_Interface` type is similar to `_Mixed` but considers empty strings as empty values.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$requiredValue = TypeParser::new('type: interface | required');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_Interface;

$requiredValue = _Interface::new()->required();
```
{% endtab %}
{% endtabs %}

#### Callable

The `_Callable` type allows defining custom validation logic using a closure.

{% code title="Defining Callable" %}
```php
use Lucasjs7\SimpleValidator\Type\_Callable;

$validator = _Callable::new();
```
{% endcode %}

**Defining Custom Validation**

You can pass the callable in the constructor or use the `function()` method:

{% code title="Custom Callable" %}
```php
// Via constructor
$cpfValidator = _Callable::new(
    label: 'CPF',
    callable: function($value) {
        if (!validateCPF($value)) {
            $this->error('Invalid CPF');
            return false;
        }
        return true;
    }
);

// Via function() method
$emailDomainValidator = _Callable::new('Corporate Email')
    ->function(function($value) {
        if (!str_ends_with($value, '@company.com')) {
            $this->error('Must be a corporate email');
            return false;
        }
        return true;
    })
    ->required();
```
{% endcode %}

**How It Works**

* The callable receives the value to be validated
* The function is bound to the `_Callable` instance, so you can use `$this->error()` to set custom error messages
* Returns `true` for valid, `false` for invalid

**Examples**

{% code title="Callable Examples" %}
```php
// Validate custom phone format
$phone = _Callable::new('Phone')
    ->function(function($value) {
        $pattern = '/^\(\d{2}\)\s?\d{4,5}-\d{4}$/';
        if (!preg_match($pattern, $value)) {
            $this->error('Invalid format. Use: (XX) XXXXX-XXXX');
            return false;
        }
        return true;
    })
    ->required();

// Validate unique username (with database check)
$username = _Callable::new('Username')
    ->function(function($value) {
        if (userExists($value)) {
            $this->error('This username is already in use');
            return false;
        }
        return true;
    });
```
{% endcode %}
