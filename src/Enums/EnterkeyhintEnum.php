<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum EnterkeyhintEnum: string
{
    /**
     * A tecla "Enter" exibe "Concluído"
     */
    case done = 'done';

    /**
     * A tecla "Enter" exibe "Enter"
     */
    case enter = 'enter';

    /**
     * A tecla "Enter" exibe "Ir"
     */
    case go = 'go';

    /**
     * A tecla "Enter" exibe "Próximo"
     */
    case next = 'next';

    /**
     * A tecla "Enter" exibe "Anterior"
     */
    case previous = 'previous';

    /**
     * A tecla "Enter" exibe "Buscar"
     */
    case search = 'search';

    /**
     * A tecla "Enter" exibe "Enviar"
     */
    case send = 'send';
}