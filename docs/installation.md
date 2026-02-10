# Instalação

- [Conheça o SimpleValidator](#meet-simplevalidator)
    - [Por que SimpleValidator?](#why-simplevalidator)
- [Instalando o SimpleValidator](#installing-simplevalidator)
    - [Requisitos](#requirements)
    - [Instalação via Composer](#installation-via-composer)
- [Configuração](#configuration)
    - [Definindo o Idioma](#setting-the-language)
    - [Modo Debug](#debug-mode)
- [Próximos Passos](#next-steps)

<a id="meet-simplevalidator"></a>
## Conheça o SimpleValidator

SimpleValidator é uma biblioteca de validação de dados leve e flexível para PHP. Ela permite validar estruturas de dados complexas, como arrays aninhados, APIs JSON e formulários, usando uma sintaxe fluente expressiva ou definições baseadas em strings.

Seja construindo um formulário de contato simples ou validando payloads de API complexos com objetos e arrays aninhados, o SimpleValidator fornece ferramentas poderosas para garantir que seus dados atendam aos requisitos da sua aplicação.

<a id="why-simplevalidator"></a>
### Por que SimpleValidator?

Existem várias razões pelas quais o SimpleValidator pode ser a escolha certa para o seu projeto:

#### Sintaxe Expressiva

O SimpleValidator permite definir regras de validação de forma clara e legível. Você pode usar a API fluente com encadeamento de métodos ou uma sintaxe baseada em string fácil de armazenar e configurar:

```php
// Sintaxe Fluente
_String::new()->min(3)->max(100)->required()

// Sintaxe String
'type: string | min: 3 | max: 100 | required'
```

#### Estruturas de Dados Aninhadas

Diferente de muitas bibliotecas de validação, o SimpleValidator foi construído desde o início para lidar com dados aninhados. Ele fornece três estruturas poderosas: `Struct`, `Slice` e `Map` que podem ser combinadas para validar qualquer formato de dado.

#### Cobertura Reflection

O SimpleValidator pode criar validadores automaticamente a partir de suas classes PHP existentes usando Reflection. Não há necessidade de duplicar suas regras de validação - basta anotar os parâmetros do construtor ou propriedades.

<a id="installing-simplevalidator"></a>
## Instalando o SimpleValidator

<a id="requirements"></a>
### Requisitos

- PHP 8.1 ou superior
- Composer

<a id="installation-via-composer"></a>
### Instalação via Composer

Você pode instalar o SimpleValidator usando o Composer:

```bash
composer require lucasjs7/simple-validator
```

Isso instalará automaticamente as dependências necessárias:

- `lucasjs7/simple-cli-table` - Para saída de erros formatada em modo debug
- `lucasjs7/convert-data-size` - Para validação de tamanho de arquivo

<a id="configuration"></a>
## Configuração

O SimpleValidator funciona "out of the box" com padrões sensatos, mas você pode personalizar seu comportamento.

<a id="setting-the-language"></a>
### Definindo o Idioma

Por padrão, o SimpleValidator usa Inglês para mensagens de erro. Você pode alterar para Português:

```php
use Lucasjs7\SimpleValidator\Language\Language;
use Lucasjs7\SimpleValidator\Language\eLanguage;

// Definir idioma para Português (Brasil)
Language::set(eLanguage::PT);

// Definir idioma para Inglês (padrão)
Language::set(eLanguage::EN);
```

<a id="debug-mode"></a>
### Modo Debug

Em produção, o SimpleValidator lança exceções com mensagens de erro limpas. Durante o desenvolvimento, você pode habilitar o modo debug para saída de erro detalhada com rastreamento (backtrace):

```php
use Lucasjs7\SimpleValidator\Core;
use Lucasjs7\SimpleValidator\eMode;

// Habilitar modo debug (mostra erros detalhados com backtrace)
Core::$mode = eMode::DEBUG;

// Modo produção (padrão - lança exceções limpas)
Core::$mode = eMode::PRODUCTION;
```

<a id="next-steps"></a>
## Próximos Passos

Agora que você instalou o SimpleValidator, pode querer aprender mais sobre:

- **[Início Rápido (Quickstart)](quickstart.md)** - Aprenda o básico com exemplos completos
- **[Estruturas de Dados](structures.md)** - Entenda Struct, Slice e Map
- **[Tipos Disponíveis](types.md)** - Explore todos os tipos de validação
- **[Regras Disponíveis](rules.md)** - Saiba sobre regras como min, max, regex
