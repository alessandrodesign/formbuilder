<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

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

file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'index.html', $response);

dd($response);