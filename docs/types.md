# Tipos Disponíveis

- [Introdução](#introduction)
- [Tipos String](#string-types)
    - [String](#type-string)
- [Tipos Numéricos](#numeric-types)
    - [Int](#type-int)
    - [Float](#type-float)
- [Tipos Booleanos](#boolean-types)
    - [Bool](#type-bool)
- [Tipos de Data](#date-types)
    - [Date](#type-date)
- [Tipos de Arquivo](#file-types)
    - [File](#type-file)
    - [Image](#type-image)
- [Tipos Especiais](#special-types)
    - [Mixed](#type-mixed)
    - [Interface](#type-interface)
    - [Callable](#type-callable)

<a id="introduction"></a>
## Introdução

O SimpleValidator fornece uma variedade de tipos para validar diferentes tipos de dados. Cada tipo é uma classe no namespace `Lucasjs7\SimpleValidator\Type`.

Todos os tipos compartilham alguns métodos comuns:

| Método | Descrição |
|--------|-----------|
| `new(?string $label)` | Cria uma nova instância com um label opcional para mensagens de erro |
| `required(bool $value = true)` | Torna o campo obrigatório |
| `label(string $value)` | Define um nome legível para mensagens de erro |
| `info()` | Retorna uma representação em string das regras de validação |

<a id="string-types"></a>
## Tipos String

<a id="type-string"></a>
### String

O tipo `_String` valida se um valor é uma string.

```php
use Lucasjs7\SimpleValidator\Type\_String;

$validator = _String::new();
```

#### Regras Disponíveis

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `min(int $length)` | Comprimento mínimo de caracteres | `->min(3)` |
| `max(int $length)` | Comprimento máximo de caracteres | `->max(100)` |
| `options(string ...$values)` | O valor deve ser uma das opções fornecidas | `->options('ativo', 'inativo')` |
| `regex(string $pattern)` | O valor deve corresponder à expressão regular | `->regex('/^[a-z]+$/')` |

#### Exemplos

```php
// Nome de usuário: 3-20 caracteres alfanuméricos
$username = _String::new('Usuário')
    ->min(3)
    ->max(20)
    ->regex('/^[a-zA-Z0-9_]+$/')
    ->required();

// Status: deve ser uma das opções
$status = _String::new()
    ->options('pendente', 'aprovado', 'rejeitado')
    ->required();

// Bio: opcional, máx 500 caracteres
$bio = _String::new()->max(500);
```

<a id="numeric-types"></a>
## Tipos Numéricos

<a id="type-int"></a>
### Int

O tipo `_Int` valida se um valor é um número inteiro.

```php
use Lucasjs7\SimpleValidator\Type\_Int;

$validator = _Int::new();
```

#### Regras Disponíveis

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `min(int $value)` | Valor numérico mínimo | `->min(0)` |
| `max(int $value)` | Valor numérico máximo | `->max(100)` |
| `unsigned()` | O valor deve ser positivo (> 0) | `->unsigned()` |

#### Exemplos

```php
// Idade: 0 a 150
$age = _Int::new('Idade')
    ->min(0)
    ->max(150)
    ->required();

// Quantidade: inteiro positivo
$quantity = _Int::new()
    ->unsigned()
    ->required();

// Pontuação: -100 a 100
$score = _Int::new()
    ->min(-100)
    ->max(100);
```

<a id="type-float"></a>
### Float

O tipo `_Float` valida se um valor é um número de ponto flutuante.

```php
use Lucasjs7\SimpleValidator\Type\_Float;

$validator = _Float::new();
```

#### Regras Disponíveis

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `min(float $value)` | Valor numérico mínimo | `->min(0.0)` |
| `max(float $value)` | Valor numérico máximo | `->max(99.99)` |
| `unsigned()` | O valor deve ser positivo (> 0) | `->unsigned()` |

#### Exemplos

```php
// Preço: número positivo
$price = _Float::new('Preço')
    ->unsigned()
    ->required();

// Classificação: 0.0 a 5.0
$rating = _Float::new()
    ->min(0.0)
    ->max(5.0);

// Temperatura: pode ser negativo
$temperature = _Float::new()
    ->min(-50.0)
    ->max(50.0);
```

<a id="boolean-types"></a>
## Tipos Booleanos

<a id="type-bool"></a>
### Bool

O tipo `_Bool` valida se um valor é booleano.

```php
use Lucasjs7\SimpleValidator\Type\_Bool;

$validator = _Bool::new();
```

#### Exemplos

```php
// Flag Ativo
$isActive = _Bool::new('Ativo')->required();

// Inscrição na newsletter (opcional)
$newsletter = _Bool::new();
```

<a id="date-types"></a>
## Tipos de Data

<a id="type-date"></a>
### Date

O tipo `_Date` valida se um valor é uma string correspondente a um formato de data.

```php
use Lucasjs7\SimpleValidator\Type\_Date;

$validator = _Date::new();
```

#### Regras Disponíveis

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `format(string $format)` | Formato de data esperado (formato PHP date) | `->format('Y-m-d')` |

O formato padrão é `Y-m-d`.

#### Exemplos

```php
// Data de nascimento: formato YYYY-MM-DD
$birthDate = _Date::new('Data de Nascimento')
    ->format('Y-m-d')
    ->required();

// Criado em: formato datetime
$createdAt = _Date::new()
    ->format('Y-m-d H:i:s')
    ->required();

// Formato de data brasileiro
$brDate = _Date::new()
    ->format('d/m/Y');
```

<a id="file-types"></a>
## Tipos de Arquivo

<a id="type-file"></a>
### File

O tipo `_File` valida arquivos enviados (espera o formato `$_FILES` do PHP).

```php
use Lucasjs7\SimpleValidator\Type\_File;

$validator = _File::new();
```

#### Regras Disponíveis

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `ext(string ...$extensions)` | Extensões de arquivo permitidas | `->ext('pdf', 'docx')` |
| `max(string $size)` | Tamanho máximo do arquivo | `->max('5MB')` |

#### Exemplos

```php
// Somente documentos PDF, máx 10MB
$document = _File::new('Documento')
    ->ext('pdf')
    ->max('10MB')
    ->required();

// Múltiplas extensões permitidas
$attachment = _File::new()
    ->ext('pdf', 'doc', 'docx', 'txt')
    ->max('5MB');
```

> **Nota:** O tipo `_File` espera dados no formato `$_FILES` do PHP com as chaves: `name`, `type`, `size`, `tmp_name`, `full_path`, e `error`.

<a id="type-image"></a>
### Image

O tipo `_Image` estende `_File` com validações específicas para imagens.

```php
use Lucasjs7\SimpleValidator\Type\_Image;

$validator = _Image::new();
```

#### Regras Disponíveis

Herda todas as regras de `_File`, mais:

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `width(int $maxWidth)` | Largura máxima em pixels | `->width(1920)` |
| `height(int $maxHeight)` | Altura máxima em pixels | `->height(1080)` |

#### Exemplos

```php
// Avatar: JPEG/PNG, máx 2MB, máx 500x500
$avatar = _Image::new('Avatar')
    ->ext('jpg', 'jpeg', 'png')
    ->max('2MB')
    ->width(500)
    ->height(500)
    ->required();

// Imagem Hero: dimensões maiores permitidas
$heroImage = _Image::new()
    ->ext('jpg', 'png', 'webp')
    ->max('5MB')
    ->width(1920)
    ->height(1080);
```

<a id="special-types"></a>
## Tipos Especiais

<a id="type-mixed"></a>
### Mixed

O tipo `_Mixed` aceita qualquer valor. Útil para campos onde você só se importa com a presença, não com o tipo.

```php
use Lucasjs7\SimpleValidator\Type\_Mixed;

$anyValue = _Mixed::new()->required();
```

<a id="type-interface"></a>
### Interface

O tipo `_Interface` é similar ao `_Mixed` mas considera strings vazias como valores vazios.

```php
use Lucasjs7\SimpleValidator\Type\_Interface;

$requiredValue = _Interface::new()->required();
```

<a id="type-callable"></a>
### Callable

O tipo `_Callable` permite definir lógica de validação personalizada usando uma função.

```php
use Lucasjs7\SimpleValidator\Type\_Callable;

$validator = _Callable::new();
```

#### Definindo Validação Personalizada

Você pode passar o callable no construtor ou usar o método `function()`:

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

#### Como Funciona

- O callable recebe o valor a ser validado
- A função é vinculada à instância de `_Callable`, então você pode usar `$this->error()` para definir mensagens de erro personalizadas
- Retorna `true` para válido, `false` para inválido

#### Exemplos

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
