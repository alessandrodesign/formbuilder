<?php

namespace AlessandroDesign\FormBuilder\Enums;

/**
 * Enum Popovertargetaction
 *
 * Enumeração para ações do elemento popover.
 */
enum PopovertargetactionEnum: string
{
    /**
     * @description O elemento popover é oculto quando você clica no botão.
     */
    case HIDE = 'hide';

    /**
     * @description O elemento popover é exibido quando você clica no botão.
     */
    case SHOW = 'show';

    /**
     * @description Valor padrão. O elemento popover é alternado entre ocultar e exibir quando você clica no botão.
     */
    case TOGGLE = 'toggle';
}