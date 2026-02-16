---
description: >-
  Regras são métodos que adicionam restrições aos tipos: required, min, max,
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

# Regras Disponíveis

### Introdução

Regras são métodos que adicionam restrições aos tipos. Cada tipo suporta regras diferentes com base no que faz sentido para aquele tipo de dado. Esta página documenta todas as regras disponíveis e quais tipos as suportam.

### Regras Comuns

Essas regras estão disponíveis em todos os tipos.

#### required

A regra `required` torna um campo obrigatório. Sem esta regra, os campos são opcionais por padrão.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | required');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_String::new()->required();
```
{% endtab %}
{% endtabs %}

Você também pode desabilitar condicionalmente o required:

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Opcional por padrão (basta omitir 'required')
TypeParser::new('type: string');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_String::new()->required(false); // Mesmo que não chamar required()
```
{% endtab %}
{% endtabs %}

#### label

A regra `label` define um nome legível para o campo, usado em mensagens de erro.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | label: Nome Completo | required');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_String::new('Nome Completo');          // Via construtor
_String::new()->label('Nome Completo'); // Via método
```
{% endtab %}
{% endtabs %}

**Sem label:**

```
O valor é obrigatório (caminho: nome_completo).
```

**Com label:**
```
O campo 'Nome Completo' é obrigatório.
```

### Regras de Tamanho

#### min

A regra `min` define uma restrição mínima. Seu comportamento depende do tipo:

| Tipo             | Comportamento         |
| ---------------- | --------------------- |
| `_String`        | Mínimo de caracteres  |
| `_Int`, `_Float` | Valor numérico mínimo |

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// String: pelo menos 3 caracteres
TypeParser::new('type: string | min: 3');

// Inteiro: valor >= 18
TypeParser::new('type: int | min: 18');

// Float: valor >= 0.0
TypeParser::new('type: float | min: 0');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// String: pelo menos 3 caracteres
_String::new()->min(3);

// Inteiro: valor >= 18
_Int::new()->min(18);

// Float: valor >= 0.0
_Float::new()->min(0.0);
```
{% endtab %}
{% endtabs %}

#### max

A regra `max` define uma restrição máxima. Seu comportamento depende do tipo:

| Tipo              | Comportamento                                       |
| ----------------- | --------------------------------------------------- |
| `_String`         | Máximo de caracteres                                |
| `_Int`, `_Float`  | Valor numérico máximo                               |
| `_File`, `_Image` | Tamanho máximo do arquivo (como string ex: `'5MB'`) |

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// String: no máximo 100 caracteres
TypeParser::new('type: string | max: 100');

// Inteiro: valor <= 100
TypeParser::new('type: int | max: 100');

// Arquivo: máx 5 megabytes
TypeParser::new('type: file | max: 5MB');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// String: no máximo 100 caracteres
_String::new()->max(100);

// Inteiro: valor <= 100
_Int::new()->max(100);

// Arquivo: máx 5 megabytes
_File::new()->max('5MB');
```
{% endtab %}
{% endtabs %}

#### unsigned

A regra `unsigned` garante que um valor numérico seja positivo (>= 0).

**Tipos suportados:** `_Int`, `_Float`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: int | unsigned');
TypeParser::new('type: float | unsigned');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_Int::new()->unsigned();
_Float::new()->unsigned();
```
{% endtab %}
{% endtabs %}

Isso é equivalente a `->min(0)` mas é mais semântico e legível.

### Regras de Conteúdo

#### options

A regra `options` restringe o valor a um conjunto predefinido de valores permitidos (como um enum).

**Tipos suportados:** `_String`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: string | options: rascunho, publicado, arquivado');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_String::new()->options('rascunho', 'publicado', 'arquivado');
```
{% endtab %}
{% endtabs %}

Se o valor não for uma das opções, a validação falha com uma mensagem de erro listando as opções válidas.

#### regex

A regra `regex` valida o valor contra um padrão de expressão regular.

**Tipos suportados:** `_String`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Cuidado com caracteres especiais e o delimitador |
TypeParser::new('type: string | regex: /^[a-z0-9_]+$/');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_String::new()->regex('/^[a-z0-9_]+$/');
```
{% endtab %}
{% endtabs %}

> **Aviso:** Ao usar regex na sintaxe de string, tenha cuidado com o caractere `|` pois ele é usado como delimitador. Considere usar sintaxe fluente para padrões complexos.

**Padrões Comuns**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Email (básico)
$emailValidator = TypeParser::new('type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/');

// Alphanumérico apenas
$alphanumericValidator = TypeParser::new('type: string | regex: /^[a-zA-Z0-9]+$/');

// CEP Brasileiro
$cepValidator = TypeParser::new('type: string | regex: /^\d{5}-?\d{3}$/');

// Telefone com código de país opcional
$phoneValidator = TypeParser::new('type: string | regex: /^\+?\d{10,15}$/');

// Formato slug
$slugValidator = TypeParser::new('type: string | regex: /^[a-z0-9]+(?:-[a-z0-9]+)*$/');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;

// Email (básico)
$emailValidator = _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/');

// Alphanumérico apenas
$alphanumericValidator = _String::new()->regex('/^[a-zA-Z0-9]+$/');

// CEP Brasileiro
$cepValidator = _String::new()->regex('/^\d{5}-?\d{3}$/');

// Telefone com código de país opcional
$phoneValidator = _String::new()->regex('/^\+?\d{10,15}$/');

// Formato slug
$slugValidator = _String::new()->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/');
```
{% endtab %}
{% endtabs %}

### Regras de Data

#### format

A regra `format` especifica o formato de data esperado usando caracteres de formato de data do PHP.

**Tipos suportados:** `_Date`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: date | format: Y-m-d');
TypeParser::new('type: date | format: d/m/Y');
TypeParser::new('type: date | format: Y-m-d H:i:s');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_Date::new()->format('Y-m-d');
_Date::new()->format('d/m/Y');
_Date::new()->format('Y-m-d H:i:s');
```
{% endtab %}
{% endtabs %}

**Formatos Comuns**

| Formato       | Exemplo             | Descrição          |
| ------------- | ------------------- | ------------------ |
| `Y-m-d`       | 2024-12-25          | Data ISO (padrão)  |
| `d/m/Y`       | 25/12/2024          | Brasileiro/Europeu |
| `m/d/Y`       | 12/25/2024          | Americano          |
| `Y-m-d H:i:s` | 2024-12-25 14:30:00 | Datetime           |
| `d-m-Y`       | 25-12-2024          | Traços             |

### Regras de Arquivo

#### ext

A regra `ext` especifica extensões de arquivo permitidas.

**Tipos suportados:** `_File`, `_Image`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: file | ext: pdf, doc, docx');
TypeParser::new('type: image | ext: jpg, jpeg, png');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_File::new()->ext('pdf', 'doc', 'docx');
_Image::new()->ext('jpg', 'jpeg', 'png', 'webp');
```
{% endtab %}
{% endtabs %}

#### width

A regra `width` define a largura máxima em pixels para imagens.

**Tipos suportados:** `_Image`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: image | width: 1920');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_Image::new()->width(1920);
```
{% endtab %}
{% endtabs %}

#### height

A regra `height` define a altura máxima em pixels para imagens.

**Tipos suportados:** `_Image`

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

TypeParser::new('type: image | height: 1080');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
_Image::new()->height(1080);
```
{% endtab %}
{% endtabs %}

### Sintaxe String

O SimpleValidator suporta uma sintaxe baseada em string para definir regras de validação. Isso é útil quando você quer armazenar regras em arquivos de configuração ou banco de dados.

#### Visão Geral da Sintaxe

Regras são definidas como uma string delimitada por pipe:

```
type: <tipo> | regra: valor | regra: valor | flag
```

* `type` é sempre obrigatório primeiro
* Regras com valores usam o formato `regra: valor`
* Flags (como `required` ou `unsigned`) não precisam de valor

#### Tipos Disponíveis

| String do Tipo | Classe       |
| -------------- | ------------ |
| `string`       | `_String`    |
| `int`          | `_Int`       |
| `float`        | `_Float`     |
| `bool`         | `_Bool`      |
| `date`         | `_Date`      |
| `file`         | `_File`      |
| `image`        | `_Image`     |
| `mixed`        | `_Mixed`     |
| `interface`    | `_Interface` |
| `callable`     | `_Callable`  |

#### Regras Disponíveis em Sintaxe String

| Regra      | Exemplo                |
| ---------- | ---------------------- |
| `required` | `required`             |
| `label`    | `label: Nome Completo` |
| `min`      | `min: 3`               |
| `max`      | `max: 100`             |
| `unsigned` | `unsigned`             |
| `options`  | `options: a, b, c`     |
| `regex`    | `regex: /^[a-z]+$/`    |
| `format`   | `format: Y-m-d`        |
| `pattern`  | `pattern: meuPadrao`   |
| `ext`      | `ext: jpg, png, pdf`   |
| `width`    | `width: 1920`          |
| `height`   | `height: 1080`         |

#### Exemplos

{% code title="Exemplos Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

// Validação de string simples
TypeParser::new('type: string | min: 3 | max: 100 | required');

// Inteiro com intervalo
TypeParser::new('type: int | min: 0 | max: 100 | required');

// Float positivo
TypeParser::new('type: float | unsigned | required');

// Enum de status
TypeParser::new('type: string | options: ativo, inativo, pendente | required');

// Data com formato personalizado
TypeParser::new('type: date | format: d/m/Y | required');

// Campo opcional com label
TypeParser::new('type: string | max: 500 | label: Biografia');

// Arquivo com extensões e tamanho
TypeParser::new('type: file | ext: pdf, docx | max: 5MB | required');

// Imagem com dimensões
TypeParser::new('type: image | ext: jpg, png | width: 1920 | height: 1080');
```
{% endcode %}
