<?php

use Ntfy\Json;
use Ntfy\Auth\Token;

class AuthTokenTest extends TestCase
{
    protected static Token $auth;

    protected static string $method = 'token';
    protected static string $token;

    public static function setUpBeforeClass(): void
    {
        $fixture = Json::decode(self::loadFixture('auth.json'));
        self::$token = $fixture->token;

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
