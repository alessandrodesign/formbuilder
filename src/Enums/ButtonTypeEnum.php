<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum ButtonTypeEnum: string
{
    /**
     * O botão é um botão clicável
     */
    case BUTTON = 'button';
    /**
     * O botão é um botão de envio (envia dados do formulário)
     */
    case SUBMIT = 'submit';
    /**
     * O botão é um botão de reinicialização (redefine os dados do formulário para seus valores iniciais)
     */
    case RESET = 'reset';
}
