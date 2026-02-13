---
description: >-
  Customizando o comportamento do SimpleValidator: Idioma e Modo Debug.
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

# Configuração

O SimpleValidator funciona com padrões que provavelmente atenderão suas necessidades, mas você pode personalizar seu comportamento.

### Definindo o Idioma

Por padrão, o SimpleValidator usa Inglês para mensagens de erro, mas pode ser alterado para Português Brasileiro:

{% code title="Definindo o idioma" %}
```php
use Lucasjs7\SimpleValidator\Language\Language;
use Lucasjs7\SimpleValidator\Language\eLanguage;

// Definir idioma para Português Brasileiro
Language::set(eLanguage::PT);

// Definir idioma para Inglês (padrão)
Language::set(eLanguage::EN);
```
{% endcode %}

### Modo Debug

Em produção, o SimpleValidator lança exceções com mensagens de erro limpas.

Durante o desenvolvimento, você pode habilitar o modo debug para saída de erro detalhada com rastreamento (backtrace):

{% code title="Ativando modo DEBUG" %}
```php
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\eMode;

// Habilitar modo debug (mostra erros detalhados com backtrace)
Core::$mode = eMode::DEBUG;

// Modo produção (padrão - lança exceções limpas)
Core::$mode = eMode::PRODUCTION;
```
{% endcode %}
