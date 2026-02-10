# Regras Disponíveis

- [Introdução](#introduction)
- [Regras Comuns](#common-rules)
    - [required](#rule-required)
    - [label](#rule-label)
- [Regras de Tamanho](#size-rules)
    - [min](#rule-min)
    - [max](#rule-max)
    - [unsigned](#rule-unsigned)
- [Regras de Conteúdo](#content-rules)
    - [options](#rule-options)
    - [regex](#rule-regex)
- [Regras de Data](#date-rules)
    - [format](#rule-format)
- [Regras de Arquivo](#file-rules)
    - [ext](#rule-ext)
    - [width](#rule-width)
    - [height](#rule-height)
- [Sintaxe String](#string-syntax)
    - [Visão Geral da Sintaxe](#syntax-overview)
    - [Tipos Disponíveis](#available-types)
    - [Regras Disponíveis em Sintaxe String](#available-rules-string)
    - [Exemplos](#string-examples)

<a id="introduction"></a>
## Introdução

Regras são métodos que adicionam restrições aos tipos. Cada tipo suporta regras diferentes com base no que faz sentido para aquele tipo de dado. Esta página documenta todas as regras disponíveis e quais tipos as suportam.

<a id="common-rules"></a>
## Regras Comuns

Essas regras estão disponíveis em todos os tipos.

<a id="rule-required"></a>
### required

A regra `required` torna um campo obrigatório. Sem esta regra, os campos são opcionais por padrão.

```php
// Sintaxe fluente
_String::new()->required()

// Sintaxe String
'type: string | required'
```

Você também pode desabilitar condicionalmente o required:

```php
_String::new()->required(false) // Mesmo que não chamar required()
```

<a id="rule-label"></a>
### label

A regra `label` define um nome legível para o campo, usado em mensagens de erro.

```php
// Sintaxe fluente
_String::new('Nome Completo')           // Via construtor
_String::new()->label('Nome Completo')  // Via método

// Sintaxe String
'type: string | label: Nome Completo | required'
```

**Sem label:**
```
O valor é obrigatório (caminho: nome_completo).
```

**Com label:**
```
O campo 'Nome Completo' é obrigatório.
```

<a id="size-rules"></a>
## Regras de Tamanho

<a id="rule-min"></a>
### min

A regra `min` define uma restrição mínima. Seu comportamento depende do tipo:

| Tipo | Comportamento |
|------|---------------|
| `_String` | Mínimo de caracteres |
| `_Int`, `_Float` | Valor numérico mínimo |

```php
// String: pelo menos 3 caracteres
_String::new()->min(3)
'type: string | min: 3'

// Inteiro: valor >= 18
_Int::new()->min(18)
'type: int | min: 18'

// Float: valor >= 0.0
_Float::new()->min(0.0)
'type: float | min: 0'
```

<a id="rule-max"></a>
### max

A regra `max` define uma restrição máxima. Seu comportamento depende do tipo:

| Tipo | Comportamento |
|------|---------------|
| `_String` | Máximo de caracteres |
| `_Int`, `_Float` | Valor numérico máximo |
| `_File`, `_Image` | Tamanho máximo do arquivo (como string ex: `'5MB'`) |

```php
// String: no máximo 100 caracteres
_String::new()->max(100)
'type: string | max: 100'

// Inteiro: valor <= 100
_Int::new()->max(100)
'type: int | max: 100'

// Arquivo: máx 5 megabytes
_File::new()->max('5MB')
```

<a id="rule-unsigned"></a>
### unsigned

A regra `unsigned` garante que um valor numérico seja positivo (>= 0).

**Tipos suportados:** `_Int`, `_Float`

```php
// Sintaxe fluente
_Int::new()->unsigned()
_Float::new()->unsigned()

// Sintaxe String
'type: int | unsigned'
'type: float | unsigned'
```

Isso é equivalente a `->min(0)` mas é mais semântico e legível.

<a id="content-rules"></a>
## Regras de Conteúdo

<a id="rule-options"></a>
### options

A regra `options` restringe o valor a um conjunto predefinido de valores permitidos (como um enum).

**Tipos suportados:** `_String`

```php
// Sintaxe fluente
_String::new()->options('rascunho', 'publicado', 'arquivado')

// Sintaxe String
'type: string | options: rascunho, publicado, arquivado'
```

Se o valor não for uma das opções, a validação falha com uma mensagem de erro listando as opções válidas.

<a id="rule-regex"></a>
### regex

A regra `regex` valida o valor contra um padrão de expressão regular.

**Tipos suportados:** `_String`

```php
// Sintaxe fluente
_String::new()->regex('/^[a-z0-9_]+$/')

// Sintaxe String (cuidado com caracteres especiais)
'type: string | regex: /^[a-z0-9_]+$/'
```

> **Aviso:** Ao usar regex na sintaxe de string, tenha cuidado com o caractere `|` pois ele é usado como delimitador. Considere usar sintaxe fluente para padrões complexos.

#### Padrões Comuns

```php
// Email (básico)
->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')

// Alphanumérico apenas
->regex('/^[a-zA-Z0-9]+$/')

// CEP Brasileiro
->regex('/^\d{5}-?\d{3}$/')

// Telefone com código de país opcional
->regex('/^\+?\d{10,15}$/')

// Formato slug
->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
```

<a id="date-rules"></a>
## Regras de Data

<a id="rule-format"></a>
### format

A regra `format` especifica o formato de data esperado usando caracteres de formato de data do PHP.

**Tipos suportados:** `_Date`

```php
// Sintaxe fluente
_Date::new()->format('Y-m-d')
_Date::new()->format('d/m/Y')
_Date::new()->format('Y-m-d H:i:s')

// Sintaxe String
'type: date | format: Y-m-d'
'type: date | format: d/m/Y'
'type: date | format: Y-m-d H:i:s'
```

#### Formatos Comuns

| Formato | Exemplo | Descrição |
|---------|---------|-----------|
| `Y-m-d` | 2024-12-25 | Data ISO (padrão) |
| `d/m/Y` | 25/12/2024 | Brasileiro/Europeu |
| `m/d/Y` | 12/25/2024 | Americano |
| `Y-m-d H:i:s` | 2024-12-25 14:30:00 | Datetime |
| `d-m-Y` | 25-12-2024 | Traços |

<a id="file-rules"></a>
## Regras de Arquivo

<a id="rule-ext"></a>
### ext

A regra `ext` especifica extensões de arquivo permitidas.

**Tipos suportados:** `_File`, `_Image`

```php
// Sintaxe fluente
_File::new()->ext('pdf', 'doc', 'docx')
_Image::new()->ext('jpg', 'jpeg', 'png', 'webp')

// Sintaxe String
'type: file | ext: pdf, doc, docx'
'type: image | ext: jpg, jpeg, png'
```

<a id="rule-width"></a>
### width

A regra `width` define a largura máxima em pixels para imagens.

**Tipos suportados:** `_Image`

```php
// Sintaxe fluente
_Image::new()->width(1920)

// Sintaxe String
'type: image | width: 1920'
```

<a id="rule-height"></a>
### height

A regra `height` define a altura máxima em pixels para imagens.

**Tipos suportados:** `_Image`

```php
// Sintaxe fluente
_Image::new()->height(1080)

// Sintaxe String
'type: image | height: 1080'
```

<a id="string-syntax"></a>
## Sintaxe String

O SimpleValidator suporta uma sintaxe baseada em string para definir regras de validação. Isso é útil quando você quer armazenar regras em arquivos de configuração ou banco de dados.

<a id="syntax-overview"></a>
### Visão Geral da Sintaxe

Regras são definidas como uma string delimitada por pipe:

```
type: <tipo> | regra: valor | regra: valor | flag
```

- `type` é sempre obrigatório primeiro
- Regras com valores usam o formato `regra: valor`
- Flags (como `required` ou `unsigned`) não precisam de valor

<a id="available-types"></a>
### Tipos Disponíveis

| String do Tipo | Classe |
|----------------|--------|
| `string` | `_String` |
| `int` | `_Int` |
| `float` | `_Float` |
| `bool` | `_Bool` |
| `date` | `_Date` |
| `file` | `_File` |
| `image` | `_Image` |
| `mixed` | `_Mixed` |
| `interface` | `_Interface` |
| `callable` | `_Callable` |

<a id="available-rules-string"></a>
### Regras Disponíveis em Sintaxe String

| Regra | Exemplo |
|-------|---------|
| `required` | `required` |
| `label` | `label: Nome Completo` |
| `min` | `min: 3` |
| `max` | `max: 100` |
| `unsigned` | `unsigned` |
| `options` | `options: a, b, c` |
| `regex` | `regex: /^[a-z]+$/` |
| `format` | `format: Y-m-d` |
| `pattern` | `pattern: meuPadrao` |
| `ext` | `ext: jpg, png, pdf` |
| `width` | `width: 1920` |
| `height` | `height: 1080` |

<a id="string-examples"></a>
### Exemplos

```php
// Validação de string simples
'type: string | min: 3 | max: 100 | required'

// Inteiro com intervalo
'type: int | min: 0 | max: 100 | required'

// Float positivo
'type: float | unsigned | required'

// Enum de status
'type: string | options: ativo, inativo, pendente | required'

// Data com formato personalizado
'type: date | format: d/m/Y | required'

// Campo opcional com label
'type: string | max: 500 | label: Biografia'

// Arquivo com extensões e tamanho
'type: file | ext: pdf, docx | max: 5MB | required'

// Imagem com dimensões
'type: image | ext: jpg, png | width: 1920 | height: 1080'
```
