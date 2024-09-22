<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum RelEnum: string
{
    /**
     * Especifica que o documento referenciado não faz parte do site atual
     */
    case External = 'external';
    /**
     * Links para um documento de ajuda
     */
    case Help = 'help';
    /**
     * Links para informações de direitos autorais do documento
     */
    case License = 'license';
    /**
     * O próximo documento em uma seleção
     */
    case Next = 'next';
    /**
     * Vincula a um documento não endossado, como um link pago.
     * (“nofollow” é usado pelo Google para especificar que o mecanismo de busca do Google não deve seguir esse link)
     */
    case Nofollow = 'nofollow';
    /**
     *
     */
    case Noopener = 'noopener';
    /**
     * Especifica que o navegador não deve enviar um cabeçalho HTTP referrer se o usuário seguir o hiperlink
     */
    case Noreferrer = 'noreferrer';
    /**
     *
     */
    case Opener = 'opener';
    /**
     * O documento anterior em uma seleção
     */
    case Prev = 'prev';
    /**
     * Links para uma ferramenta de pesquisa para o documento
     */
    case Search = 'search';
}
