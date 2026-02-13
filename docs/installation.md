---
description: >-
  Requisitos e instalação via Composer.
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

# Instalação

Siga as instruções abaixo para configurar os requisitos necessários e realizar a instalação do pacote via Composer.

### Requisitos

* PHP 8.1 ou superior
* Composer
* Extensão BCMath
* Extensão MBString

### Instalação via Composer

Você pode instalar o SimpleValidator usando o Composer:

{% code title="Terminal" %}
```bash
composer require lucasjs7/simple-validator
```
{% endcode %}

Isso instalará automaticamente as dependências necessárias:

* `lucasjs7/simple-cli-table` - Para saída de erros formatada em modo debug
* `lucasjs7/convert-data-size` - Para validação de tamanho de arquivo
