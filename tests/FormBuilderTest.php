<?php

use AlessandroDesign\FormBuilder\Enums\EnctypeEnum;
use AlessandroDesign\FormBuilder\Enums\MethodEnum;
use AlessandroDesign\FormBuilder\Form;
use PHPUnit\Framework\TestCase;
use Random\RandomException;

class FormBuilderTest extends TestCase
{
    public function testFormInstance()
    {
        $form = new Form(
            'formTeste',
            MethodEnum::POST,
            'https://localhost:8080/post',
            EnctypeEnum::MultipartFormData
        );

        $form->setId('formTeste');

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('formTeste', $form->getId());
        $this->assertEquals(MethodEnum::POST || MethodEnum::POST->value, $form->getMethod());
        $this->assertEquals(EnctypeEnum::MultipartFormData || EnctypeEnum::MultipartFormData->value, $form->getEnctype());
    }

    public function testStaticFormCreation()
    {
        $form = Form::create(
            'formTeste',
            MethodEnum::POST,
            'https://localhost:8080/post',
            EnctypeEnum::MultipartFormData
        );

        $form->setId('formTeste');

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('formTeste', $form->getId());
    }

    /**
     * @throws DOMException
     */
    public function testFormRendering()
    {
        $form = Form::create(
            'formTeste',
            MethodEnum::POST,
            'https://localhost:8080/post',
            EnctypeEnum::MultipartFormData
        );

        $form->setId('formTeste');

        $htmlOutput = $form->render();
        $this->assertStringContainsString('<form', $htmlOutput);
        $this->assertStringContainsString('id="formTeste"', $htmlOutput);
    }

    public function testToStringRendering()
    {
        $form = Form::create(
            'formTeste',
            MethodEnum::POST,
            'https://localhost:8080/post',
            EnctypeEnum::MultipartFormData
        );

        $form->setId('formTeste');

        $htmlOutput = (string)$form;
        $this->assertStringContainsString('<form', $htmlOutput);
        $this->assertStringContainsString('id="formTeste"', $htmlOutput);
    }

    /**
     * @throws DOMException
     */
    public function testFormStructureWithElements()
    {
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

        $htmlOutput = $form->render();
        $this->assertStringContainsString('input', $htmlOutput);
        $this->assertStringContainsString('form-control', $htmlOutput);
    }

    /**
     * @throws DOMException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws RandomException
     */
    public function testCsrfTokenGeneration()
    {
        $form = Form::create(
            'formTeste',
            MethodEnum::POST,
            'validateToken.php',
            EnctypeEnum::MultipartFormData
        );

        $form->useToken();
        $htmlOutput = $form->render();

        // Verifica se o token CSRF está presente no formulário
        $this->assertStringContainsString('name="' . Form::csrf_token . '"', $htmlOutput);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws RandomException
     */
    public function testCsrfTokenValidation()
    {
        // Simula um token válido para testar a validação
        $_POST[Form::csrf_token] = Form::generateToken();

        $isValid = Form::validateToken();
        $this->assertTrue($isValid);
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws RandomException
     */
    public function testInvalidCsrfToken()
    {
        // Simula um token inválido para testar a falha de validação
        $_POST[Form::csrf_token] = 'invalid_token';

        $isValid = Form::validateToken();
        $this->assertFalse($isValid);
    }
}