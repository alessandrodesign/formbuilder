<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum DraggableEnum: string
{
    /**
     * Especifica que o elemento é arrastável
     */
    case true = 'true';

    /**
     * Especifica que o elemento não é arrastável
     */
    case false = 'false';

    /**
     * Usa o comportamento padrão do navegador
     */
    case auto = 'auto';
}
