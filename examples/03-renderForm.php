<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;

require_once implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

$form = Form::create(
    'formTeste',
    MethodEnum::POST,
    'https://localhost:8080/post',
    EnctypeEnum::MultipartFormData
);

dd($form->render());