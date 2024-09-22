<?php

namespace AlessandroDesign\FormBuilder\Enums;

enum MethodEnum: string
{
    /**
     * Padrão. Acrescenta os dados do formulário ao URL em pares nome/valor: URL?name=value&name=value
     * @note
     * 1. Acrescenta dados de formulário ao URL em pares nome/valor
     * 2. O comprimento de um URL é limitado (cerca de 3.000 caracteres)
     * 3. Nunca use GET para enviar dados confidenciais! (será visível no URL)
     * 4. Útil para envios de formulários onde um usuário deseja marcar o resultado
     * 5. GET é melhor para dados não seguros, como strings de consulta no Google
     */
    case GET = 'get';
    /**
     * Envia os dados do formulário como uma pós-transação HTTP
     * @note
     * 1. Acrescenta dados do formulário dentro do corpo da solicitação HTTP (os dados não são mostrados no URL)
     * 2. Não tem limitações de tamanho
     * 3. Os envios de formulários com POST não podem ser marcados como favoritos
     */
    case POST = 'post';
}
