---
description: >-
  Requirements and installation via Composer.
icon: download
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

# Installation

Follow the instructions below to configure the necessary requirements and install the package via Composer.

### Requirements

* PHP 8.1 or higher
* Composer
* BCMath Extension
* MBString Extension

### Installation via Composer

You can install SimpleValidator using Composer:

{% code title="Terminal" %}
```bash
composer require lucasjs7/simple-validator
```
{% endcode %}

This will automatically install the required dependencies:

* `lucasjs7/simple-cli-table` - For formatted error output in debug mode
* `lucasjs7/convert-data-size` - For file size validation
