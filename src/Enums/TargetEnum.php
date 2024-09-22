<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum TargetEnum: string
{
    /**
     * A resposta é exibida em uma nova janela ou guia
     */
    case Blank = '_blank';
    /**
     * The response is displayed in the same frame (this is default)
     */
    case Self = '_self';
    /**
     * A resposta é exibida no quadro pai
     */
    case Parent = '_parent';
    /**
     * A resposta é exibida no corpo da janela
     */
    case Top = '_top';
    /**
     * A resposta é exibida em um iframe nomeado
     */
    case Framename = '';
}
