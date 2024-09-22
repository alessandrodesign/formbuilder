<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum DirEnum:string
{
    /**
     * Padrão. Direção do texto da esquerda para a direita
     */
    case ltr = 'ltr';

    /**
     * Direção do texto da direita para a esquerda
     */
    case rtl = 'rtl';

    /**
     * Deixar o navegador determinar a direção do texto com base no conteúdo (recomendado apenas se a direção do texto for desconhecida)
     */
    case auto = 'auto';
}
