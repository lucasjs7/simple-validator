---
description: >-
  Um guia rápido para começar a validar dados com SimpleValidator.
icon: rabbit-running
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

# Início Rápido

### Introdução

O SimpleValidator oferece uma maneira poderosa e expressiva de validar dados em suas aplicações PHP. Seja validando entrada de formulário, payloads de API ou dados de configuração, o SimpleValidator tem o que você precisa.

Neste guia rápido vamos percorrer um exemplo completo de validação de entrada de usuário e tratamento de erros de validação. Ao final você terá uma compreensão sólida de como o SimpleValidator funciona.

### Início Rápido

Vamos construir um exemplo completo validando um formulário de cadastro de usuário com nome, e-mail e idade.

#### Definindo um Validador

Primeiro, criamos um validador que descreve a estrutura de dados esperada:

{% code title="Definindo Validador" %}
```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;

$validator = Struct::new([
    'name'  => _String::new()->min(3)->max(100)->required(),
    'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
    'age'   => _Int::new()->min(18)->max(120)->required(),
]);
```
{% endcode %}

Neste exemplo:

* `name` deve ser uma string com entre 3 e 100 caracteres, e é obrigatório
* `email` deve ser um endereço de e-mail válido, e é obrigatório
* `age` deve ser um inteiro entre 18 e 120, e é obrigatório

#### Validando Dados

Agora vamos validar alguns dados de entrada. O método `validate` lançará uma `ValidatorException` se a validação falhar:

{% code title="Validando Dados" %}
```php
use Lucasjs7\SimpleValidator\ValidatorException;

$userData = [
    'name'  => 'João Silva',
    'email' => 'joao@exemplo.com',
    'age'   => 25,
];

try {
    $validator->validate($userData);

    // Validação passou! Continue com sua lógica...
    echo "Dados do usuário válidos!";

} catch (ValidatorException $e) {
    // Validação falhou
    echo "Erro de validação: " . $e->getMessage();
}
```
{% endcode %}

Se a validação passar, a execução continua normalmente. Se falhar, uma `ValidatorException` é lançada com uma mensagem de erro descritiva.

#### Exibindo Erros de Validação

A `ValidatorException` fornece informações úteis sobre o que deu errado:

{% code title="Tratamento de Erros" %}
```php
try {
    $validator->validate($invalidData);
} catch (ValidatorException $e) {
    // Obter a mensagem de erro
    $message = $e->getMessage();
    // Exemplo: "O valor deve ter pelo menos 3 caracteres (caminho: name)."

    // Obter o caminho do campo que falhou
    $errorPath = $e->getErrorPath();
    // Exemplo: ['name']

    // Para estruturas aninhadas, o caminho mostra a localização completa
    // Exemplo: ['usuarios', 0, 'endereco', 'cep']
}
```
{% endcode %}

> **Dica:** Você também pode usar o método `debug()` durante o desenvolvimento para obter saída de erro detalhada:

{% code title="Debug" %}
```php
$e->debug(); // Imprime informações formatadas do erro e encerra execução
```
{% endcode %}

### Uma Nota sobre Campos Opcionais

Por padrão todos os campos são **opcionais**. Se um campo não estiver presente nos dados de entrada, a validação passará.

No entanto, se o campo for fornecido ele deverá obedecer às regras de validação.

{% code title="Campos Opcionais" %}
```php
$validator = Struct::new([
    'nickname' => _String::new()->max(6),
]);

$validator->validate([]); // Válido
$validator->validate(['nickname' => 'Name']); // Válido
$validator->validate(['nickname' => null]); // Inválido
$validator->validate(['nickname' => 'TooLongName']); // Inválido
```
{% endcode %}

Para tornar um campo obrigatório, use o método `required()`:

{% code title="Campo Obrigatório" %}
```php
$validator = Struct::new([
    'nickname' => _String::new()->max(50)->required(), // Agora obrigatório!
]);

// Isso agora lança uma exceção
$validator->validate([]);
```
{% endcode %}

### Duas Opções de Sintaxe

O SimpleValidator oferece duas maneiras de definir regras de validação. Você pode usar a que parecer mais natural para o seu caso de uso, ou misturá-las conforme necessário.

#### Sintaxe Fluente

A sintaxe fluente usa classes PHP e encadeamento de métodos:

{% code title="Sintaxe Fluente" %}
```php
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\Type\_Int;
use Lucasjs7\SimpleValidator\Type\_Date;

$validator = Struct::new([
    'title'       => _String::new()->min(5)->max(200)->required(),
    'description' => _String::new()->max(1000),
    'views'       => _Int::new()->unsigned(),
    'published'   => _Date::new()->format('Y-m-d'),
]);
```
{% endcode %}

**Benefícios:**

* Autocomplete completo na IDE
* Verificação de tipos
* Fácil descoberta de métodos disponíveis

#### Sintaxe String

A sintaxe string usa strings delimitadas por pipe (`|`):

{% code title="Sintaxe String" %}
```php
$validator = Struct::new([
    'title'       => 'type: string | min: 5 | max: 200 | required',
    'description' => 'type: string | max: 1000',
    'views'       => 'type: int | unsigned',
    'published'   => 'type: date | format: Y-m-d',
]);
```
{% endcode %}

**Benefícios:**

* Fácil de armazenar em arquivos de configuração ou banco de dados
* Mais conciso para validações simples
* Familiar se você já usou a validação do Laravel

Ambas as sintaxes são totalmente intercambiáveis e podem ser misturadas no mesmo `Struct`:

{% code title="Sintaxe Mista" %}
```php
$validator = Struct::new([
    'title' => _String::new()->min(5)->required(),  // Fluente
    'views' => 'type: int | unsigned',              // String
]);
```
{% endcode %}
