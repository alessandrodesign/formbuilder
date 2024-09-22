<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;
use Random\RandomException;

require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

try {
    $form = Form::create(
        'formTeste',
        MethodEnum::POST,
        'validateToken.php',
        EnctypeEnum::MultipartFormData
    )->setClass('row g-3');

    $form->useToken();

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

    $form->button('send', 'send', 'btn btn-them', 'send', 'submit', false, null, null, null);

    $response = $form->render();
} catch (DOMException|\Psr\SimpleCache\InvalidArgumentException|RandomException $e) {
    $response = $e->getMessage();
}

file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'index.html', $response);

dd($response);