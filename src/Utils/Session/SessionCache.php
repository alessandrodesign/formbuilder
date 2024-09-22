<?php declare(strict_types=1);

namespace AlessandroDesign\FormBuilder\Utils\Session;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * Classe que manipula a sessão como um sistema de cache para tokens CSRF.
 */

/**
 * Classe que manipula a sessão como um sistema de cache para tokens CSRF.
 */
class SessionCache implements CacheInterface
{
    /**
     * Lê um valor da sessão.
     *
     * @param string $key Chave do valor a ser lido.
     * @param mixed|null $default Valor padrão se a chave não existir.
     *
     * @return mixed O valor armazenado ou o valor padrão.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Define um valor na sessão.
     *
     * @param string $key Chave do valor a ser armazenado.
     * @param mixed $value Valor a ser armazenado.
     * @param DateInterval|int|null $ttl Ignorado neste caso.
     *
     * @return bool True se o valor for armazenado corretamente.
     */
    public function set(string $key, mixed $value, DateInterval|int $ttl = null): bool
    {
        $_SESSION[$key] = $value;
        return true;
    }

    /**
     * Verifica se uma chave existe na sessão.
     *
     * @param string $key Chave a ser verificada.
     *
     * @return bool True se a chave existir.
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove um valor da sessão.
     *
     * @param string $key Chave do valor a ser removido.
     *
     * @return bool True se o valor for removido corretamente.
     */
    public function delete(string $key): bool
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
            return true;
        }

        return false;
    }

    /**
     * Limpa todos os itens da sessão.
     *
     * @return bool Sempre retorna true.
     */
    public function clear(): bool
    {
        session_unset();
        return true;
    }

    /**
     * Retorna o número de itens na sessão.
     *
     * @return int O número de itens.
     */
    public function count(): int
    {
        return count($_SESSION);
    }

    /**
     * Obtém múltiplos itens da sessão.
     *
     * @param iterable $keys Chaves dos valores a serem lidos.
     * @param mixed|null $default Valor padrão se a chave não existir.
     *
     * @return array Associativo com os valores correspondentes.
     */
    public function getMultiple(iterable $keys, mixed $default = null): array
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }
        return $values;
    }

    /**
     * Define múltiplos itens na sessão.
     *
     * @param iterable $values Associativo com chaves e valores a serem armazenados.
     * @param DateInterval|int|null $ttl Ignorado neste caso.
     *
     * @return bool
     */
    public function setMultiple(iterable $values, DateInterval|int $ttl = null): bool
    {
        $setted = false;
        foreach ($values as $key => $value) {
            $setted = $this->set($key, $value, $ttl);
            if (!$setted) {
                break;
            }
        }
        return $setted;
    }

    /**
     * Remove múltiplos itens da sessão.
     *
     * @param iterable $keys Chaves dos valores a serem removidos.
     *
     * @return bool
     */
    public function deleteMultiple(iterable $keys): bool
    {
        $deleted = false;
        foreach ($keys as $key) {
            $deleted = $this->delete($key);
            if (!$deleted) {
                break;
            }
        }
        return $deleted;
    }
}