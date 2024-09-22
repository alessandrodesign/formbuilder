<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum InputmodeEnum: string
{
    /**
     * Teclado numérico apenas, geralmente com uma tecla de vírgula
     */
    case decimal = 'decimal';

    /**
     * Teclado de texto, com teclas típicas para endereços de e-mail, como [@]
     */
    case email = 'email';

    /**
     * Nenhum teclado deve aparecer
     */
    case none = 'none';

    /**
     * Teclado numérico apenas
     */
    case numeric = 'numeric';

    /**
     * Teclado de texto, geralmente com a tecla [enter] exibindo [ir]
     */
    case search = 'search';

    /**
     * Teclado numérico apenas, geralmente com teclas [+], [*] e [#]
     */
    case tel = 'tel';

    /**
     * Padrão. Teclado de texto
     */
    case text = 'text';

    /**
     * Teclado de texto, com teclas típicas para endereços web, como [.] e [/], e uma tecla especial [.com],
     * ou outros domínios de acordo com as configurações locais.
     */
    case url = 'url';
}

