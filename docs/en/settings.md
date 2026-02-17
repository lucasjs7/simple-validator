---
description: >-
  Customizing SimpleValidator behavior: Language and Debug Mode.
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

# Configuration

SimpleValidator works with defaults that will likely meet your needs, but you can customize its behavior.

### Setting the Language

By default, SimpleValidator uses English for error messages, but it can be changed to Brazilian Portuguese:

{% code title="Setting the language" %}
```php
use Lucasjs7\SimpleValidator\Language\Language;
use Lucasjs7\SimpleValidator\Language\eLanguage;

// Set language to Brazilian Portuguese
Language::set(eLanguage::PT);

// Set language to English (default)
Language::set(eLanguage::EN);
```
{% endcode %}

### Debug Mode

In production, SimpleValidator throws exceptions with clean error messages.

During development, you can enable debug mode for detailed error output with backtrace:

{% code title="Enabling DEBUG mode" %}
```php
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\eMode;

// Enable debug mode (shows detailed errors with backtrace)
Core::$mode = eMode::DEBUG;

// Production mode (default - throws clean exceptions)
Core::$mode = eMode::PRODUCTION;
```
{% endcode %}
