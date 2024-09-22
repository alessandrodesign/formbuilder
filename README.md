# FormBuilder

FormBuilder é uma interface poderosa e flexível para criação de formulários HTML no PHP, com suporte para tokens CSRF e várias opções de personalização. Este pacote visa facilitar a construção de formulários seguros e escaláveis para desenvolvedores PHP.

## Requisitos

- PHP >= 8.3
- Composer

## Instalação

Para instalar o pacote, utilize o Composer:

```bash
composer require alessandrodesign/formbuilder
```

## Exemplos de Uso

### Criação de Formulário

Você pode criar instâncias de formulário de duas maneiras: diretamente pela classe ou utilizando o método estático `create`.

#### Instância Tradicional

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php';

$form = new Form(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);
```

#### Instância com Método Estático

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php';

$form = Form::create(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);
```

### Renderização do Formulário

Você pode renderizar o formulário diretamente usando o método `render` ou utilizando o método mágico `__toString()`.

#### Método `render`

```php
<?php

require './vendor/autoload.php';

echo $form->render();
```

#### Método `__toString()`

```php
<?php

require './vendor/autoload.php';

echo $form;
```

### Estrutura do Formulário

Abaixo está um exemplo completo de como estruturar um formulário com diferentes tipos de campos.

```php
<?php

use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php';

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'https://localhost:8080/post',
        EnctypeEnum::MultipartFormData
    )->setClass('row g-3');

    // Adiciona campos de texto, radio, checkbox e arquivos
    $form->inputText('Nome', 'nome', placeholder: 'Digite seu nome')
        ->addClassElement('form-control')
        ->addParent('col-md-6', 'input-group');

    $form->inputRadio('Gênero', 'genero', options: ['Masculino', 'Feminino'])
        ->addClassElement('form-check-input')
        ->addParent('col-md-6', 'input-group');

    $form->inputCheckbox('Preferências', 'preferencias', options: ['Opção 1', 'Opção 2'])
        ->addClassElement('form-check-input')
        ->addParent('col-md-6', 'input-group');

    $form->inputFile('Anexar Arquivo', 'anexo')
        ->addClassElement('form-control')
        ->addParent('col-md-12', 'input-group');

    echo $form->render();
} catch (DOMException $e) {
    echo $e->getMessage();
}
```

### Uso de Select

O campo select suporta a adição de opções com ou sem grupos.

```php
<?php

use AlessandroDesign\FormBuilder\Form;

$form = Form::create(
    'formSelect',
    MethodEnum::POST,
    'https://localhost:8080/post'
);

$form->select('Escolha uma opção', 'opcao')
    ->addOptions([
        'Grupo 1' => ['valor1' => 'Opção 1', 'valor2' => 'Opção 2'],
        'Grupo 2' => ['valor3' => 'Opção 3', 'valor4' => 'Opção 4']
    ])
    ->addClassElement('form-select')
    ->addParent('col-md-12');

echo $form->render();
```

### Uso de Botões

Adicione botões de envio ao final do formulário.

```php
<?php

$form->button('Enviar', 'submit', 'btn btn-primary', 'Enviar');
echo $form->render();
```

### Segurança com Token CSRF

O FormBuilder inclui suporte para proteção CSRF. Para ativar essa funcionalidade, use o método `useToken()`.

#### Definindo Token

```php
$form->useToken();
```

#### Validação de Token

```php
if (Form::validateToken()) {
    echo 'Token válido';
} else {
    throw new Exception('Token inválido');
}
```

## Contribuição

Contribuições são bem-vindas! Por favor, sinta-se à vontade para enviar Pull Requests ou abrir Issues no [GitHub](https://github.com/alessandrodesign/formbuilder).

## Licença

Este projeto é licenciado sob a [MIT License](LICENSE).