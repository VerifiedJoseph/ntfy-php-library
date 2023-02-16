<?php

namespace Ntfy\Auth;

use Ntfy\Auth;

/**
 * Class for setting access token authentication
 */
class Token extends Auth
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
