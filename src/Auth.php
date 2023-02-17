<?php

namespace Ntfy;

class Auth
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
     *
     * @param string $username
     * @param string $password
     * @deprecated Setting username and password authentication with `Auth` is deprecated. Use `Auth\User` instead.
     */
    public function __construct(string $username = '', string $password = '')
    {
        $this->method = 'user';
        $this->username = $username;
        $this->password = $password;
    }

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
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
