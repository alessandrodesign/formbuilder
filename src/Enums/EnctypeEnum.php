<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum EnctypeEnum: string
{
    /**
     * Padrão. Todos os caracteres são codificados antes do envio (os espaços são convertidos em símbolos "+" e os caracteres especiais são convertidos em valores ASCII HEX)
     */
    case ApplicationXWwwFormUrlencoded = 'application/x-www-form-urlencoded';
    /**
     * Este valor é necessário caso o usuário faça upload de um arquivo através do formulário
     */
    case MultipartFormData = 'multipart/form-data';
    /**
     * Envia dados sem qualquer codificação. Não recomendado
     */
    case TextPlain = 'text/plain';
}
