<?php

declare(strict_types=1);

namespace Ntfy\Auth;

/**
 * Class for setting access token authentication
 */
class Token extends AbstractAuth
{
    /** @var string $method Authentication method */
    protected string $method = 'token';

    /**
     * Set access token
     *
     * @param string $token Access token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
