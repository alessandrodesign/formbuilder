<?php

namespace AlessandroDesign\FormBuilder\Enums;

/**
 * Enum InputType
 *
 * Enumeração para tipos de elementos de input HTML.
 */
enum InputTypeEnum: string
{
    /**
     * @description Define um botão clicável (geralmente usado com JavaScript para ativar um script).
     */
    case BUTTON = 'button';

    /**
     * @description Define uma caixa de seleção.
     */
    case CHECKBOX = 'checkbox';

    /**
     * @description Define um seletor de cores.
     */
    case COLOR = 'color';

    /**
     * @description Define um controle de data (ano, mês, dia, sem horário).
     */
    case DATE = 'date';

    /**
     * @description Define um controle de data e hora (ano, mês, dia, hora, sem fuso horário).
     */
    case DATETIME_LOCAL = 'datetime-local';

    /**
     * @description Define um campo para endereço de e-mail.
     */
    case EMAIL = 'email';

    /**
     * @description Define um campo de seleção de arquivos e um botão "Buscar" (para uploads de arquivos).
     */
    case FILE = 'file';

    /**
     * @description Define um campo de entrada oculto.
     */
    case HIDDEN = 'hidden';

    /**
     * @description Define uma imagem como o botão de envio.
     */
    case IMAGE = 'image';

    /**
     * @description Define um controle de mês e ano (sem fuso horário).
     */
    case MONTH = 'month';

    /**
     * @description Define um campo para inserir um número.
     */
    case NUMBER = 'number';

    /**
     * @description Define um campo para senha.
     */
    case PASSWORD = 'password';

    /**
     * @description Define um botão de seleção.
     */
    case RADIO = 'radio';

    /**
     * @description Define um controle de intervalo (como um controle deslizante).
     */
    case RANGE = 'range';

    /**
     * @description Define um botão de resetar.
     */
    case RESET = 'reset';

    /**
     * @description Define um campo de texto para inserção de uma string de busca.
     */
    case SEARCH = 'search';

    /**
     * @description Define um botão de envio.
     */
    case SUBMIT = 'submit';

    /**
     * @description Define um campo para inserção de número de telefone.
     */
    case TEL = 'tel';

    /**
     * @description Define um campo de texto de linha única (padrão).
     */
    case TEXT = 'text';

    /**
     * @description Define um controle para inserir uma hora (sem fuso horário).
     */
    case TIME = 'time';

    /**
     * @description Define um campo para inserção de uma URL.
     */
    case URL = 'url';

    /**
     * @description Define um controle de semana e ano (sem fuso horário).
     */
    case WEEK = 'week';
}