# FormBuilder

Interface de criação de formulário com token CSRF

### Como usar:

```php
// Instanciando formálio

<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

$form = new Form(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);
```

- ouinstancia via método estático

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

$form = Form::create(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);
```

### Renderizando formulário para html

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

$form = Form::create(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);

try {
    echo $form->render();
} catch (DOMException $e) {
}
```

- ou utilizando `__toString()` com método estático

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

echo Form::create(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);
```

### Estrutura do formulário

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'https://localhost:8080/post',
        EnctypeEnum::MultipartFormData
    );

    $form->inputText('Teste 1', 'teste1', name: 'teste1', placeholder: 'testestets')
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12', 'input-group');

    $form->inputRadio('Teste 2', 'teste2', name: 'teste2', value: null, options: ['valor1', 'valor2'])
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->inputCheckbox('Teste 3', 'teste3', name: 'teste3', value: null, options: ['Valor 1' => 'valor1', 'Valor 2' => 'valor2', 'Valor 3' => 'valor3'])
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->inputFile('Teste 4', 'teste4', name: 'teste4')
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $response = $form->render();
} catch (DOMException $e) {
    $response = $e->getMessage();
}

echo $response;
```

- Uso do select

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'https://localhost:8080/post',
        EnctypeEnum::MultipartFormData
    );

    $form->inputText('Teste 1', 'teste1', name: 'teste1', placeholder: 'testestets')
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12', 'input-group');

    $form->inputRadio('Teste 2', 'teste2', name: 'teste2', value: 'valor1', options: ['valor1', 'valor2'])
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->inputCheckbox('Teste 3', 'teste3', name: 'teste3', value: 'valor2', options: ['Valor 1' => 'valor1', 'Valor 2' => 'valor2', 'Valor 3' => 'valor3'])
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->inputFile('Teste 4', 'teste4', name: 'teste4')
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->select('Teste 5 Select', 'teste5', 'form-select', 'teste5', 'valor6')
        ->addOptions([
            'Grupo 1' => [
                'valor1' => 'valor 1',
                'valor2' => 'valor 2',
                'valor3' => 'valor 3',
                'valor4' => 'valor 4',
            ],
            'Grupo 2' => [
                'valor5' => 'valor 5',
                'valor6' => 'valor 6',
                'valor7' => 'valor 7',
                'valor8' => 'valor 8',
            ],
        ])
        ->addClassLabel('form-label')
        ->addClassElement('form-control')
        ->addParent('col-md-12');

    $form->select('Teste 6 Select', 'teste6', 'form-select', 'teste6', 'valor2')
        ->addOptions([
            'valor1' => 'valor 1',
            'valor2' => 'valor 2',
            'valor3' => 'valor 3',
            'valor4' => 'valor 4',
        ])
        ->addClassLabel('form-label')
        ->addParent('col-md-12');

    $response = $form->render();
} catch (DOMException $e) {
    $response = $e->getMessage();
}

echo $response;
```

- uso de botões

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'https://localhost:8080/post',
        EnctypeEnum::MultipartFormData
    )->setClass('row g-3');
    
    // corpo do formulário

    $form->button('send', 'send', 'btn btn-them', 'send', 'submit', false, null, null, null);

    $response = $form->render();
} catch (DOMException $e) {
    $response = $e->getMessage();
}

echo $response;
```

### CSRF Token

```php
<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;
use Random\RandomException;

require './vendor/autoload.php'

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'validateToken.php',
        EnctypeEnum::MultipartFormData
    )->setClass('row g-3');

    // define campo CSRF token
    $form->useToken();

    // Corpo do formulário

    $response = $form->render();
} catch (DOMException|\Psr\SimpleCache\InvalidArgumentException|RandomException $e) {
    $response = $e->getMessage();
}

echo $response;
```

- validação de token

```php
<?php

use AlessandroDesign\FormBuilder\Form;

require './vendor/autoload.php'

try {
    if (Form::validateToken()) {
        $response = 'Token válido';
    } else {
        throw new \Exception('Token inválido');
    }
} catch (\Psr\SimpleCache\InvalidArgumentException $e) {
    $response = $e->getMessage();
} catch (\Random\RandomException $e) {
    $response = $e->getMessage();
} catch (\Exception $e) {
    $response = $e->getMessage();
}

echo $response;
```