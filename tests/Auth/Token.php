<?php

use Ntfy\Auth\Token;

class AuthTokenTest extends TestCase
{
    protected static Token $auth;

    protected static string $method = 'token';
    protected static string $token = 'tk_rHIb9qXgN3b1JJwiT9VVi5tjzHOph';

    public static function setUpBeforeClass(): void
    {
        self::$auth = new Token(self::$token);
    }

    /**
     * Test `getMethod()`
     */
    public function testGetMethod(): void
    {
        $this->assertEquals(self::$method, self::$auth->getMethod());
    }

    /**
     * Test `getToken()`
     */
    public function testGetToken(): void
    {
        $this->assertEquals(self::$token, self::$auth->getToken());
    }
}
