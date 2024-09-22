<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum SpellcheckEnum: string
{
    /**
     * O elemento terá sua ortografia e gramática verificadas
     */
    case true = 'true';

    /**
     * O elemento não será verificado
     */
    case false = 'false';
}
