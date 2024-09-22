<?php

namespace AlessandroDesign\FormBuilder\Utils;

use function transliterator_transliterate;

class StringSanitizer
{
    /**
     * Sanitiza uma string removendo caracteres especiais, acentos,
     * transformando em minúsculas e substituindo espaços por um separador.
     *
     * @param string $input A string de entrada para sanitização.
     * @param string $separator O caractere a ser usado para substituir os espaços (padrão: '-').
     * @return string A string sanitizada.
     */
    public static function sanitize(string $input, string $separator = '-'): string
    {
        // Validação de separador (aceita apenas um caractere válido)
        if ($separator === null) {
            $separator = '';
        }

        // Remover espaços em branco extras
        $input = trim($input);

        // Transforma para minúsculas com suporte a caracteres multibyte (UTF-8)
        $input = mb_strtolower($input, 'UTF-8');

        // Remove acentos e normaliza caracteres
        $input = self::removeAccents($input);

        // Remove todos os caracteres especiais, exceto letras, números e espaços
        $input = preg_replace('/[^a-z0-9\s]/u', '', $input);

        // Substitui múltiplos espaços por um único espaço e então aplica o separador
        return preg_replace('/\s+/', $separator, $input);
    }

    /**
     * Remove acentos de caracteres na string, convertendo-os para a versão não acentuada.
     *
     * @param string $input A string com acentos.
     * @return string A string sem acentos.
     */
    private static function removeAccents(string $input): string
    {
        // Utiliza a função nativa transliterator_transliterate para remover acentos e normalizar caracteres
        $normalized = transliterator_transliterate('Any-Latin; Latin-ASCII', $input);

        // Retorna a string normalizada ou o input original caso haja falha na normalização
        return $normalized ?? $input;
    }
}