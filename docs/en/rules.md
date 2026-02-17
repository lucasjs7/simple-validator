---
description: >-
  Rules are methods that add constraints to types: required, min, max,
  regex, etc.
icon: octagon-check
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

# Available Rules

### Introduction

Rules are methods that add constraints to types. Each type supports different rules based on what makes sense for that kind of data. This page documents all available rules and which types support them.

### Common Rules

These rules are available on all types.

#### required

The `required` rule makes a field mandatory. Without this rule, fields are optional by default.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | required');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_String::new()->required();
```
{% endtab %}
{% endtabs %}

You can also conditionally disable required:

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Optional by default (just omit 'required')
TypeParser::new('type: string');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_String::new()->required(false); // Same as not calling required()
```
{% endtab %}
{% endtabs %}

#### label

The `label` rule sets a readable name for the field, used in error messages.

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | label: Full Name | required');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_String::new('Full Name');          // Via constructor
_String::new()->label('Full Name'); // Via method
```
{% endtab %}
{% endtabs %}

**Without label:**

```
The value is required (path: full_name).
```

**With label:**
```
The field 'Full Name' is required.
```

### Size Rules

#### min

The `min` rule defines a minimum constraint. Its behavior depends on the type:

| Type             | Behavior              |
| ---------------- | --------------------- |
| `_String`        | Minimum characters    |
| `_Int`, `_Float` | Minimum numeric value |

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// String: at least 3 characters
TypeParser::new('type: string | min: 3');

// Integer: value >= 18
TypeParser::new('type: int | min: 18');

// Float: value >= 0.0
TypeParser::new('type: float | min: 0');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// String: at least 3 characters
_String::new()->min(3);

// Integer: value >= 18
_Int::new()->min(18);

// Float: value >= 0.0
_Float::new()->min(0.0);
```
{% endtab %}
{% endtabs %}

#### max

The `max` rule defines a maximum constraint. Its behavior depends on the type:

| Type              | Behavior                                         |
| ----------------- | ------------------------------------------------ |
| `_String`         | Maximum characters                               |
| `_Int`, `_Float`  | Maximum numeric value                            |
| `_File`, `_Image` | Maximum file size (as string e.g. `'5MB'`)       |

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// String: at most 100 characters
TypeParser::new('type: string | max: 100');

// Integer: value <= 100
TypeParser::new('type: int | max: 100');

// File: max 5 megabytes
TypeParser::new('type: file | max: 5MB');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
// String: at most 100 characters
_String::new()->max(100);

// Integer: value <= 100
_Int::new()->max(100);

// File: max 5 megabytes
_File::new()->max('5MB');
```
{% endtab %}
{% endtabs %}

#### unsigned

The `unsigned` rule ensures that a numeric value is positive (>= 0).

**Supported Types:** `_Int`, `_Float`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: int | unsigned');
TypeParser::new('type: float | unsigned');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_Int::new()->unsigned();
_Float::new()->unsigned();
```
{% endtab %}
{% endtabs %}

This is equivalent to `->min(0)` but is more semantic and readable.

### Content Rules

#### options

The `options` rule restricts the value to a predefined set of allowed values (like an enum).

**Supported Types:** `_String`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | options: draft, published, archived');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_String::new()->options('draft', 'published', 'archived');
```
{% endtab %}
{% endtabs %}

If the value is not among the options, validation fails with an error message listing the valid options.

#### regex

The `regex` rule validates the value against a regular expression pattern.

**Supported Types:** `_String`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Watch out for special characters and the | delimiter
TypeParser::new('type: string | regex: /^[a-z0-9_]+$/');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_String::new()->regex('/^[a-z0-9_]+$/');
```
{% endtab %}
{% endtabs %}

**Common Patterns**

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Email (basic)
$emailValidator = TypeParser::new('type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/');

// Alphanumeric only
$alphanumericValidator = TypeParser::new('type: string | regex: /^[a-zA-Z0-9]+$/');

// Brazilian ZIP Code
$cepValidator = TypeParser::new('type: string | regex: /^\d{5}-?\d{3}$/');

// Phone with optional country code
$phoneValidator = TypeParser::new('type: string | regex: /^\+?\d{10,15}$/');

// Slug format
$slugValidator = TypeParser::new('type: string | regex: /^[a-z0-9]+(?:-[a-z0-9]+)*$/');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;

// Email (basic)
$emailValidator = _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/');

// Alphanumeric only
$alphanumericValidator = _String::new()->regex('/^[a-zA-Z0-9]+$/');

// Brazilian ZIP Code
$cepValidator = _String::new()->regex('/^\d{5}-?\d{3}$/');

// Phone with optional country code
$phoneValidator = _String::new()->regex('/^\+?\d{10,15}$/');

// Slug format
$slugValidator = _String::new()->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/');
```
{% endtab %}
{% endtabs %}

### Date Rules

#### format

The `format` rule specifies the expected date format using PHP date format characters.

**Supported Types:** `_Date`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: date | format: Y-m-d');
TypeParser::new('type: date | format: d/m/Y');
TypeParser::new('type: date | format: Y-m-d H:i:s');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_Date::new()->format('Y-m-d');
_Date::new()->format('d/m/Y');
_Date::new()->format('Y-m-d H:i:s');
```
{% endtab %}
{% endtabs %}

**Common Formats**

| Format        | Example             | Description        |
| ------------- | ------------------- | ------------------ |
| `Y-m-d`       | 2024-12-25          | ISO Date (default) |
| `d/m/Y`       | 25/12/2024          | Brazilian/European |
| `m/d/Y`       | 12/25/2024          | US                 |
| `Y-m-d H:i:s` | 2024-12-25 14:30:00 | Datetime           |
| `d-m-Y`       | 25-12-2024          | Dashes             |

### File Rules

#### ext

The `ext` rule specifies allowed file extensions.

**Supported Types:** `_File`, `_Image`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: file | ext: pdf, doc, docx');
TypeParser::new('type: image | ext: jpg, jpeg, png');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_File::new()->ext('pdf', 'doc', 'docx');
_Image::new()->ext('jpg', 'jpeg', 'png', 'webp');
```
{% endtab %}
{% endtabs %}

#### width

The `width` rule defines the maximum width in pixels for images.

**Supported Types:** `_Image`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: image | width: 1920');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_Image::new()->width(1920);
```
{% endtab %}
{% endtabs %}

#### height

The `height` rule defines the maximum height in pixels for images.

**Supported Types:** `_Image`

{% tabs %}
{% tab title="String Syntax" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: image | height: 1080');
```
{% endtab %}

{% tab title="Fluent Syntax" %}
```php
_Image::new()->height(1080);
```
{% endtab %}
{% endtabs %}

### String Syntax

SimpleValidator supports a string-based syntax for defining validation rules. This is useful when you want to store rules in configuration files or databases.

#### Syntax Overview

Rules are defined as a pipe-delimited string:

```
type: <type> | rule: value | rule: value | flag
```

* `type` is always required first
* Rules with values use the format `rule: value`
* Flags (like `required` or `unsigned`) do not need a value

#### Available Types

| Type String | Class        |
| ----------- | ------------ |
| `string`    | `_String`    |
| `int`       | `_Int`       |
| `float`     | `_Float`     |
| `bool`      | `_Bool`      |
| `date`      | `_Date`      |
| `file`      | `_File`      |
| `image`     | `_Image`     |
| `mixed`     | `_Mixed`     |
| `interface` | `_Interface` |
| `callable`  | `_Callable`  |

#### Available Rules in String Syntax

| Rule       | Example                |
| ---------- | ---------------------- |
| `required` | `required`             |
| `label`    | `label: Full Name`     |
| `min`      | `min: 3`               |
| `max`      | `max: 100`             |
| `unsigned` | `unsigned`             |
| `options`  | `options: a, b, c`     |
| `regex`    | `regex: /^[a-z]+$/`    |
| `format`   | `format: Y-m-d`        |
| `pattern`  | `pattern: myPattern`   |
| `ext`      | `ext: jpg, png, pdf`   |
| `width`    | `width: 1920`          |
| `height`   | `height: 1080`         |

#### Examples

{% code title="String Syntax Examples" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Simple string validation
TypeParser::new('type: string | min: 3 | max: 100 | required');

// Integer with range
TypeParser::new('type: int | min: 0 | max: 100 | required');

// Positive float
TypeParser::new('type: float | unsigned | required');

// Status enum
TypeParser::new('type: string | options: active, inactive, pending | required');

// Date with custom format
TypeParser::new('type: date | format: d/m/Y | required');

// Optional field with label
TypeParser::new('type: string | max: 500 | label: Biography');

// File with extensions and size
TypeParser::new('type: file | ext: pdf, docx | max: 5MB | required');

// Image with dimensions
TypeParser::new('type: image | ext: jpg, png | width: 1920 | height: 1080');
```
{% endcode %}
