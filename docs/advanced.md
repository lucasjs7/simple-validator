# Recursos Avançados

- [Introdução](#introduction)
- [Padrões Reutilizáveis](#patterns)
    - [Salvando Padrões](#saving-patterns)
    - [Usando Padrões](#using-patterns)
- [Validação Baseada em Reflection](#reflection)
    - [Do Construtor de Classe](#from-constructor)
    - [De Método](#from-method)
    - [De Função](#from-function)
    - [Usando Atributos PHP](#using-attributes)
    - [Usando DocBlocks](#using-docblocks)
- [Validação Sem Exceções](#without-exceptions)
- [Obtendo Informações do Validador](#validator-info)

<a id="introduction"></a>
## Introdução

Esta página cobre recursos avançados do SimpleValidator que ajudam você a escrever código de validação mais limpo e fácil de manter.

<a id="patterns"></a>
## Padrões Reutilizáveis

Se você se encontrar usando a mesma configuração de validação repetidamente, pode salvá-la como um padrão nomeado e reutilizá-la em toda a sua aplicação.

<a id="saving-patterns"></a>
### Salvando Padrões

Use o método `save()` para armazenar uma configuração de validação:

```php
use Lucasjs7\SimpleValidator\Type\_Date;
use Lucasjs7\SimpleValidator\Type\_String;

// Salvar formatos de data comuns
_Date::new()->format('d/m/Y')->save('brasileiro');
_Date::new()->format('Y-m-d')->save('iso');
_Date::new()->format('Y-m-d H:i:s')->save('datetime');

// Salvar um padrão de nome de usuário
_String::new()
    ->min(3)
    ->max(20)
    ->regex('/^[a-zA-Z0-9_]+$/')
    ->save('usuario');
```

> **Dica:** Salve seus padrões no início do processo de bootstrap da sua aplicação, como em um Service Provider ou arquivo de configuração.

<a id="using-patterns"></a>
### Usando Padrões

Use o método `pattern()` para recuperar uma configuração salva:

```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_Date;
use Lucasjs7\SimpleValidator\Type\_String;

$validator = Struct::new([
    'username'   => _String::pattern('usuario')->required(),
    'birth_date' => _Date::pattern('brasileiro')->required(),
    'created_at' => _Date::pattern('datetime'),
]);
```

Você também pode usar padrões na sintaxe de string:

```php
$validator = Struct::new([
    'birth_date' => 'type: date | pattern: brasileiro | required',
]);
```

<a id="reflection"></a>
## Validação Baseada em Reflection

A classe `StructParser` pode criar validadores automaticamente a partir do seu código PHP existente usando Reflection. Isso elimina a necessidade de duplicar suas definições de campo.

<a id="from-constructor"></a>
### Do Construtor de Classe

Crie um validador a partir de um construtor de classe:

```php
use Lucasjs7\SimpleValidator\StructParser;

class User {
    public function __construct(
        public string $name,
        public string $email,
        public int $age,
        public ?string $bio = null
    ) {}
}

$validator = StructParser::new(User::class);

// Agora valide os dados antes de instanciar
$data = ['name' => 'João', 'email' => 'joao@exemplo.com', 'age' => 25];
$validator->validate($data);

// Se a validação passar, crie o objeto com segurança
$user = new User(...$data);
```

**Como funciona:**
- Parâmetros obrigatórios tornam-se campos `required`
- Parâmetros opcionais (com valores padrão) tornam-se campos opcionais
- Tipos são inferidos a partir das dicas de tipo (type hints) do PHP

<a id="from-method"></a>
### De Método

Crie um validador a partir dos parâmetros de qualquer método:

```php
class OrderService {
    public function createOrder(
        int $userId,
        float $amount,
        string $currency,
        ?string $notes = null
    ) {
        // ...
    }
}

$validator = StructParser::method(OrderService::class, 'createOrder');

$data = [
    'userId'   => 123,
    'amount'   => 99.99,
    'currency' => 'BRL',
];

$validator->validate($data);
```

<a id="from-function"></a>
### De Função

Crie um validador a partir de uma função:

```php
function processPayment(
    string $cardNumber,
    float $amount,
    bool $recurring = false
) {
    // ...
}

$validator = StructParser::function('processPayment');
```

<a id="using-attributes"></a>
### Usando Atributos PHP

Para mais controle sobre as regras de validação, use o atributo `#[TypeParser]` nos parâmetros do construtor:

```php
use Lucasjs7\SimpleValidator\StructParser;
use Lucasjs7\SimpleValidator\Type\TypeParser;

class Product {
    public function __construct(
        #[TypeParser('type: string | min: 3 | max: 200')]
        public string $name,
        
        #[TypeParser('type: float | unsigned')]
        public float $price,
        
        #[TypeParser('type: string | options: ativo, rascunho, arquivado')]
        public string $status,
        
        #[TypeParser('type: string | max: 1000')]
        public ?string $description = null
    ) {}
}

$validator = StructParser::new(Product::class);
```

<a id="using-docblocks"></a>
### Usando DocBlocks

Alternativamente, você pode usar anotações `@validate` nos DocBlocks das propriedades:

```php
class Product {
    /**
     * @validate type: string | min: 3 | max: 200
     */
    public string $name;
    
    /**
     * @validate type: float | unsigned
     */
    public float $price;
    
    /**
     * @validate type: string | options: ativo, rascunho, arquivado
     */
    public string $status;
    
    public function __construct(
        string $name,
        float $price,
        string $status
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->status = $status;
    }
}

$validator = StructParser::new(Product::class);
```

> **Nota:** A restrição `required` é determinada automaticamente com base se o parâmetro do construtor é opcional. Parâmetros sem valores padrão são obrigatórios.

<a id="without-exceptions"></a>
## Validação Sem Exceções

Por padrão, o método `validate()` lança uma `ValidatorException` quando a validação falha. Se você preferir lidar com erros sem exceções, passe `false` como segundo parâmetro:

```php
use Lucasjs7\SimpleValidator\Struct;

$validator = Struct::new([
    'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/ | required',
]);

$data = ['email' => ''];

// Retorna false ao invés de lançar exceção
if ($validator->validate(value: $data, exception: false)) {
    echo "Validação passou!";
} else {
    echo "Validação falhou: " . $validator->getError();
}
```

Esta abordagem é útil quando:
- Você está validando múltiplos conjuntos de dados e quer coletar todos os erros
- Você prefere um estilo de código mais procedural
- Você está integrando com código que não usa exceções

<a id="validator-info"></a>
## Obtendo Informações do Validador

O método `info()` retorna uma representação em string das regras de um validador. Isso é útil para debugging ou gerar documentação:

```php
use Lucasjs7\SimpleValidator\Type\_String;

$validator = _String::new()
    ->min(3)
    ->max(100)
    ->required();

echo $validator->info();
// Saída: "type: string | min: 3 | max: 100 | required: true"
```

Para estruturas (`Struct`), `info()` retorna um array:

```php
use Lucasjs7\SimpleValidator\Struct;

$validator = Struct::new([
    'name'  => 'type: string | required',
    'email' => 'type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/',
]);

print_r($validator->info());
// Saída:
// Array
// (
//     [name] => type: string | required: true
//     [email] => type: string | regex: /^[\w\.-]+@[\w\.-]+\.\w+$/
// )
```
