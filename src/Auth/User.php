<?php

declare(strict_types=1);

namespace Ntfy\Auth;

/**
 * Class for setting username and password authentication
 */
class User extends AbstractAuth
{
    /** @var string $method Authentication method */
    protected string $method = 'user';

    /**
     * Set username and password
     *
     * @param string $username Username
     * @param string $password Password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
