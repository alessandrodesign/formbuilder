<?php declare(strict_types=1);

namespace AlessandroDesign\FormBuilder\Utils\Security;

use InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;
use Random\RandomException;

/**
 * Classe responsável por gerenciar tokens CSRF (Cross-Site Request Forgery).
 * Segue princípios SOLID, utilizando injeção de dependência para manipulação de sessão.
 */
class CsrfTokenManager
{
    private const int TOKEN_LENGTH = 32;

    private CacheInterface $sessionHandler;
    private string $tokenKey;

    /**
     * Construtor da classe CsrfTokenManager.
     *
     * @param CacheInterface $sessionHandler Um manipulador de sessão implementando CacheInterface.
     * @param string $tokenKey Nome da chave onde o token será armazenado na sessão.
     */
    public function __construct(CacheInterface $sessionHandler, string $tokenKey = 'csrf_token')
    {
        $this->sessionHandler = $sessionHandler;
        $this->tokenKey = $tokenKey;
    }

    /**
     * Gera e retorna o token CSRF, criando um novo se necessário.
     *
     * @return string O token CSRF.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws RandomException
     */
    public function getToken(): string
    {
        if (!$this->sessionHandler->has($this->tokenKey)) {
            $this->generateAndStoreToken();
        }

        return $this->sessionHandler->get($this->tokenKey);
    }

    /**
     * Valida o token CSRF comparando-o com o armazenado na sessão.
     *
     * @param string $token O token fornecido pelo usuário.
     * @return bool         Retorna true se o token for válido, false caso contrário.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException Se o token fornecido estiver vazio.
     * @throws RandomException
     */
    public function validateToken(string $token): bool
    {
        $this->ensureTokenIsNotEmpty($token);
        return hash_equals($this->getToken(), $token);
    }

    /**
     * Regenera o token CSRF e armazena o novo valor na sessão.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws RandomException
     */
    public function refreshToken(): void
    {
        $this->generateAndStoreToken();
    }

    /**
     * Remove o token CSRF da sessão.
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function clearToken(): void
    {
        $this->sessionHandler->delete($this->tokenKey);
    }

    /**
     * Gera um novo token e o armazena na sessão.
     * @throws RandomException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function generateAndStoreToken(): void
    {
        $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        $this->sessionHandler->set($this->tokenKey, $token);
    }

    /**
     * Verifica se o token fornecido não está vazio.
     *
     * @param string $token O token fornecido.
     *
     * @throws InvalidArgumentException Se o token estiver vazio.
     */
    private function ensureTokenIsNotEmpty(string $token): void
    {
        if (empty($token)) {
            throw new InvalidArgumentException('CSRF token cannot be empty.');
        }
    }
}