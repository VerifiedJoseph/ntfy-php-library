<?php

declare(strict_types=1);

namespace Ntfy\Auth;

abstract class AbstractAuth
{
    /** @var string $method Authentication method */
    protected string $method;

    /** @var string $token Authentication token */
    protected string $token = '';

    /** @var string $username */
    protected string $username = '';

    /** @var string $password */
    protected string $password = '';

    /**
     * Get authentication method
     *
     * @return string
     */
    final public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get authentication token
     *
     * @return string
     */
    final public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get username
     *
     * @return string
     */
    final public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get password
     *
     * @return string
     */
    final public function getPassword(): string
    {
        return $this->password;
    }
}
