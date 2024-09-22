<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum TranslateEnum: string
{
    /**
     * Especifica que o conteúdo do elemento deve ser traduzido
     */
    case yes = 'yes';

    /**
     * Especifica que o conteúdo do elemento não deve ser traduzido
     */
    case no = 'no';
}