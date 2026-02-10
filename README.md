# SimpleValidator

Uma biblioteca de validação de dados poderosa e expressiva para PHP.

## Documentação

- **Começando**
    - [Instalação](docs/installation.md)
    - [Início Rápido (Quickstart)](docs/quickstart.md)

- **Conceitos Principais**
    - [Estruturas de Dados](docs/structures.md)
    - [Tipos Disponíveis](docs/types.md)
    - [Regras Disponíveis](docs/rules.md)

- **Avançado**
    - [Recursos Avançados](docs/advanced.md)

## Exemplo Rápido

```php
use Lucasjs7\SimpleValidator\Struct;
use Lucasjs7\SimpleValidator\Type\_String;
use Lucasjs7\SimpleValidator\ValidatorException;

$validator = Struct::new([
    'name'  => 'type: string | min: 3 | required',
    'age'   => 'type: int | min: 18 | max: 120',
    // Você pode misturar a sintaxe de string com objetos fluentes
    'email' => _String::new()->regex('/^[\w\.-]+@[\w\.-]+\.\w+$/')->required(),
]);

$data = [
    'name'  => 'John Doe',
    'age'   => 25,
    'email' => 'john@example.com',
];

try {
    $validator->validate($data);
    echo "Dados válidos!";
} catch (ValidatorException $e) {
    echo "Erro: " . $e->getMessage();
}
```

## Instalação

```bash
composer require lucasjs7/simple-validator
```

## Licença

SimpleValidator é um software de código aberto licenciado sob a [licença MIT](LICENSE).
