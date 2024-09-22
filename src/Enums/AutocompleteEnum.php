<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum AutocompleteEnum: string
{
    /**
     * Padrão. O navegador completará automaticamente os valores com base nos valores que o usuário inseriu antes
     */
    case On = 'on';
    /**
     * O usuário deve inserir um valor em cada campo para cada uso. O navegador não completa entradas automaticamente
     */
    case Off = 'off';
}
