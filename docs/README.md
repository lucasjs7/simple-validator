---
description: >-
  Uma biblioteca de validação PHP leve e fluente, que abrange estruturas de
  dados aninhadas (Struct, Slice, Map) e validação baseada em reflexão
  (reflection).
icon: sparkle
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

# Primeiros Passos

### Conheça o SimpleValidator

SimpleValidator é uma biblioteca de validação de dados leve e flexível para PHP.

Ela permite validar estruturas de dados complexas, como arrays aninhados, APIs JSON e formulários, usando uma sintaxe fluente expressiva ou definições baseadas em strings.

Seja construindo um formulário de contato simples ou validando payloads de API complexos com objetos e arrays aninhados, o SimpleValidator fornece ferramentas poderosas para garantir que seus dados atendam aos requisitos da sua aplicação.

#### Por que SimpleValidator?

Existem várias razões pelas quais o SimpleValidator pode ser a escolha certa para o seu projeto:

**Sintaxe Expressiva**

O SimpleValidator permite definir regras de validação de forma clara e legível.

Você pode usar a API fluente com encadeamento de métodos ou uma sintaxe baseada em string fácil de armazenar e configurar:

{% code title="Exemplo (fluente vs string)" %}
```php
// Sintaxe Fluente
_String::new()->min(3)->max(100)->required()

// Sintaxe String
'type: string | min: 3 | max: 100 | required'
```
{% endcode %}

**Estruturas de Dados Aninhadas**

Diferente de muitas bibliotecas de validação, o SimpleValidator foi construído desde o início para lidar com dados aninhados.

Ele fornece três estruturas poderosas: `Struct`, `Slice` e `Map` que podem ser combinadas para validar qualquer formato de dado.

{% code title="Validação com Struct, Slice e Map" %}
```php
use Lucasjs7\SimpleValidator\{Struct, Slice, Map};
use Lucasjs7\SimpleValidator\Type\{_String, _Int};

$validator = Struct::new([
    // Struct: Objeto aninhado
    'user' => Struct::new([
        'name' => _String::new()->required(),
    ]),

    // Slice: Lista de strings
    'tags' => Slice::new(
        _String::new()->min(3)
    ),

    // Map: Chaves dinâmicas
    'settings' => Map::new(
        _String::new(), // Chave (string)
        _Int::new()     // Valor (int)
    ),
]);
```
{% endcode %}

**Cobertura Reflection**

O SimpleValidator pode criar validadores automaticamente a partir de suas classes PHP existentes usando Reflection.

Não há necessidade de duplicar suas regras de validação - basta anotar os parâmetros do construtor ou propriedades.

{% code title="Gerando validator com StructParser" %}
```php
use Lucasjs7\SimpleValidator\StructParser;

class UserDTO {
    public function __construct(
        public string $name,
        public string $email,
    ) {
        // ...
    }
}

$validator = StructParser::new(UserDTO::class);
```
{% endcode %}

### Próximos Passos

Agora que você instalou o SimpleValidator, pode querer aprender mais sobre:

* [**Início Rápido**](quickstart.md) - Aprenda o básico com exemplos completos
* [**Estruturas de Dados**](structures.md) - Entenda Struct, Slice e Map
* [**Tipos Disponíveis**](types.md) - Explore todos os tipos de validação
* [**Regras Disponíveis**](rules.md) - Saiba sobre regras como min, max, regex

### Licença

SimpleValidator é um software de código aberto licenciado sob a licença MIT.
