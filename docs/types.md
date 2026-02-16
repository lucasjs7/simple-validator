---
description: >-
  O SimpleValidator oferece uma variedade de tipos para validação de dados:
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

# Tipos Disponíveis

### Introdução

O SimpleValidator fornece uma variedade de tipos para validar diferentes tipos de dados. Cada tipo é uma classe no namespace `Lucasjs7\SimpleValidator\Type`.

Todos os tipos compartilham alguns métodos comuns:

| Método                         | Descrição                                                            |
| ------------------------------ | -------------------------------------------------------------------- |
| `new(?string $label)`          | Cria uma nova instância com um label opcional para mensagens de erro |
| `required(bool $value = true)` | Torna o campo obrigatório                                            |
| `label(string $value)`         | Define um nome legível para mensagens de erro                        |
| `info()`                       | Retorna uma representação em string das regras de validação          |

### Tipos String

#### String

O tipo `_String` valida se um valor é uma string.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: string');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;

$validator = _String::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

| Método                       | Descrição                                     | Exemplo                         |
| ---------------------------- | --------------------------------------------- | ------------------------------- |
| `min(int $length)`           | Comprimento mínimo de caracteres              | `->min(3)`                      |
| `max(int $length)`           | Comprimento máximo de caracteres              | `->max(100)`                    |
| `options(string ...$values)` | O valor deve ser uma das opções fornecidas    | `->options('ativo', 'inativo')` |
| `regex(string $pattern)`     | O valor deve corresponder à expressão regular | `->regex('/^[a-z]+$/')`         |

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Nome de usuário: 3-20 caracteres alfanuméricos
$username = TypeParser::new('type: string | label: Usuário | min: 3 | max: 20 | regex: /^[a-zA-Z0-9_]+$/ | required');

// Status: deve ser uma das opções
$status = TypeParser::new('type: string | options: pendente, aprovado, rejeitado | required');

// Bio: opcional, máx 500 caracteres
$bio = TypeParser::new('type: string | max: 500');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Nome de usuário: 3-20 caracteres alfanuméricos
$username = _String::new('Usuário')->min(3)->max(20)->regex('/^[a-zA-Z0-9_]+$/')->required();

// Status: deve ser uma das opções
$status = _String::new()->options('pendente', 'aprovado', 'rejeitado')->required();

// Bio: opcional, máx 500 caracteres
$bio = _String::new()->max(500);
```
{% endtab %}
{% endtabs %}

### Tipos Numéricos

#### Int

O tipo `_Int` valida se um valor é um número inteiro.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: int');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Int;

$validator = _Int::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

| Método            | Descrição                       | Exemplo        |
| ----------------- | ------------------------------- | -------------- |
| `min(int $value)` | Valor numérico mínimo           | `->min(0)`     |
| `max(int $value)` | Valor numérico máximo           | `->max(100)`   |
| `unsigned()`      | O valor deve ser positivo (> 0) | `->unsigned()` |

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Idade: 0 a 150
$age = TypeParser::new('type: int | label: Idade | min: 0 | max: 150 | required');

// Quantidade: inteiro positivo
$quantity = TypeParser::new('type: int | unsigned | required');

// Pontuação: -100 a 100
$score = TypeParser::new('type: int | min: -100 | max: 100');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Idade: 0 a 150
$age = _Int::new('Idade')->min(0)->max(150)->required();

// Quantidade: inteiro positivo
$quantity = _Int::new()->unsigned()->required();

// Pontuação: -100 a 100
$score = _Int::new()->min(-100)->max(100);
```
{% endtab %}
{% endtabs %}

#### Float

O tipo `_Float` valida se um valor é um número de ponto flutuante.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: float');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Float;

$validator = _Float::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

| Método              | Descrição                       | Exemplo        |
| ------------------- | ------------------------------- | -------------- |
| `min(float $value)` | Valor numérico mínimo           | `->min(0.0)`   |
| `max(float $value)` | Valor numérico máximo           | `->max(99.99)` |
| `unsigned()`        | O valor deve ser positivo (> 0) | `->unsigned()` |

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Preço: número positivo
$price = TypeParser::new('type: float | label: Preço | unsigned | required');

// Classificação: 0.0 a 5.0
$rating = TypeParser::new('type: float | min: 0.0 | max: 5.0');

// Temperatura: pode ser negativo
$temperature = TypeParser::new('type: float | min: -50.0 | max: 50.0');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Preço: número positivo
$price = _Float::new('Preço')->unsigned()->required();

// Classificação: 0.0 a 5.0
$rating = _Float::new()->min(0.0)->max(5.0);

// Temperatura: pode ser negativo
$temperature = _Float::new()->min(-50.0)->max(50.0);
```
{% endtab %}
{% endtabs %}

### Tipos Booleanos

#### Bool

O tipo `_Bool` valida se um valor é booleano.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: bool');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Bool;

$validator = _Bool::new();
```
{% endtab %}
{% endtabs %}

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Termos de Serviço: obrigatório
$termsAccepted = TypeParser::new('type: bool | label: Termos | required');

// Receber Notificações: opcional
$notifications = TypeParser::new('type: bool');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Termos de Serviço: obrigatório
$termsAccepted = _Bool::new('Termos')->required();

// Receber Notificações: opcional
$notifications = _Bool::new();
```
{% endtab %}
{% endtabs %}

### Tipos de Data

#### Date

O tipo `_Date` valida se um valor é uma string correspondente a um formato de data.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: date');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Date;

$validator = _Date::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

| Método                   | Descrição                                   | Exemplo             |
| ------------------------ | ------------------------------------------- | ------------------- |
| `format(string $format)` | Formato de data esperado (formato PHP date) | `->format('Y-m-d')` |

O formato padrão é `Y-m-d`.

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Data de nascimento: formato YYYY-MM-DD
$birthDate = TypeParser::new('type: date | label: Data de Nascimento | format: Y-m-d | required');

// Criado em: formato datetime
$createdAt = TypeParser::new('type: date | format: Y-m-d H:i:s | required');

// Formato de data brasileiro
$brDate = TypeParser::new('type: date | format: d/m/Y');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Data de nascimento: formato YYYY-MM-DD
$birthDate = _Date::new('Data de Nascimento')->format('Y-m-d')->required();

// Criado em: formato datetime
$createdAt = _Date::new()->format('Y-m-d H:i:s')->required();

// Formato de data brasileiro
$brDate = _Date::new()->format('d/m/Y');
```
{% endtab %}
{% endtabs %}

### Tipos de Arquivo

#### File

O tipo `_File` valida arquivos enviados (espera o formato `$_FILES` do PHP).

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: file');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_File;

$validator = _File::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

| Método                       | Descrição                       | Exemplo                |
| ---------------------------- | ------------------------------- | ---------------------- |
| `ext(string ...$extensions)` | Extensões de arquivo permitidas | `->ext('pdf', 'docx')` |
| `max(string $size)`          | Tamanho máximo do arquivo       | `->max('5MB')`         |

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Somente documentos PDF, máx 10MB
$document = TypeParser::new('type: file | label: Documento | ext: pdf | max: 10MB | required');

// Múltiplas extensões permitidas
$attachment = TypeParser::new('type: file | ext: pdf, doc, docx, txt | max: 5MB');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Somente documentos PDF, máx 10MB
$document = _File::new('Documento')->ext('pdf')->max('10MB')->required();

// Múltiplas extensões permitidas
$attachment = _File::new()->ext('pdf', 'doc', 'docx', 'txt')->max('5MB');
```
{% endtab %}
{% endtabs %}

> **Nota:** O tipo `_File` espera dados no formato `$_FILES` do PHP com as chaves: `name`, `type`, `size`, `tmp_name`, `full_path`, e `error`.

#### Image

O tipo `_Image` estende `_File` com validações específicas para imagens.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$validator = TypeParser::new('type: image');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Image;

$validator = _Image::new();
```
{% endtab %}
{% endtabs %}

**Regras Disponíveis**

Herda todas as regras de `_File`, mais:

| Método                   | Descrição                | Exemplo          |
| ------------------------ | ------------------------ | ---------------- |
| `width(int $maxWidth)`   | Largura máxima em pixels | `->width(1920)`  |
| `height(int $maxHeight)` | Altura máxima em pixels  | `->height(1080)` |

**Exemplos**

{% tabs %}
{% tab title="Sintaxe String" %}
```php
// Avatar: JPEG/PNG, máx 2MB, máx 500x500
$avatar = TypeParser::new('type: image | label: Avatar | ext: jpg, jpeg, png | max: 2MB | width: 500 | height: 500 | required');

// Imagem Hero: dimensões maiores permitidas
$heroImage = TypeParser::new('type: image | ext: jpg, png, webp | max: 5MB | width: 1920 | height: 1080');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
// Avatar: JPEG/PNG, máx 2MB, máx 500x500
$avatar = _Image::new('Avatar')->ext('jpg', 'jpeg', 'png')->max('2MB')->width(500)->height(500)->required();

// Imagem Hero: dimensões maiores permitidas
$heroImage = _Image::new()->ext('jpg', 'png', 'webp')->max('5MB')->width(1920)->height(1080);
```
{% endtab %}
{% endtabs %}

### Tipos Especiais

#### Mixed

O tipo `_Mixed` aceita qualquer valor. Útil para campos onde você só se importa com a presença, não com o tipo.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$anyValue = TypeParser::new('type: mixed | required');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Mixed;

$anyValue = _Mixed::new()->required();
```
{% endtab %}
{% endtabs %}

#### Interface

O tipo `_Interface` é similar ao `_Mixed` mas considera strings vazias como valores vazios.

{% tabs %}
{% tab title="Sintaxe String" %}
```php
use Lucasjs7\SimpleValidator\Type\TypeParser;

$requiredValue = TypeParser::new('type: interface | required');
```
{% endtab %}

{% tab title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_Interface;

$requiredValue = _Interface::new()->required();
```
{% endtab %}
{% endtabs %}

#### Callable

O tipo `_Callable` permite definir lógica de validação personalizada usando uma função.

{% code title="Definindo Callable" %}
```php
use Lucasjs7\SimpleValidator\Type\_Callable;

$validator = _Callable::new();
```
{% endcode %}

**Definindo Validação Personalizada**

Você pode passar o callable no construtor ou usar o método `function()`:

{% code title="Callable Customizado" %}
```php
// Pelo construtor
$cpfValidator = _Callable::new(
    label: 'CPF',
    callable: function($value) {
        if (!validarCPF($value)) {
            $this->error('CPF Inválido');
            return false;
        }
        return true;
    }
);

// Pelo método function()
$emailDomainValidator = _Callable::new('Email Corporativo')
    ->function(function($value) {
        if (!str_ends_with($value, '@empresa.com.br')) {
            $this->error('Deve ser um e-mail corporativo');
            return false;
        }
        return true;
    })
    ->required();
```
{% endcode %}

**Como Funciona**

* O callable recebe o valor a ser validado
* A função é vinculada à instância de `_Callable`, então você pode usar `$this->error()` para definir mensagens de erro personalizadas
* Retorna `true` para válido, `false` para inválido

**Exemplos**

{% code title="Exemplos de Callable" %}
```php
// Validar telefone brasileiro
$phone = _Callable::new('Telefone')
    ->function(function($value) {
        $pattern = '/^\(\d{2}\)\s?\d{4,5}-\d{4}$/';
        if (!preg_match($pattern, $value)) {
            $this->error('Formato inválido. Use: (XX) XXXXX-XXXX');
            return false;
        }
        return true;
    })
    ->required();

// Validar nome de usuário único (com verificação em banco de dados)
$username = _Callable::new('Usuário')
    ->function(function($value) {
        if (usuarioExiste($value)) {
            $this->error('Este nome de usuário já está em uso');
            return false;
        }
        return true;
    });
```
{% endcode %}
