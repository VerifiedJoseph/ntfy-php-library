<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Auth\Token;
use Ntfy\Json;

#[CoversClass(Token::class)]
#[CoversClass(Ntfy\Auth::class)]
#[UsesClass(Json::class)]
class TokenTest extends TestCase
{
    protected static string $method = 'token';
    protected static string $token;

    public static function setUpBeforeClass(): void
    {
        $fixture = Json::decode(self::loadAsset('auth.json'));
        self::$token = $fixture->token;
    }

    /**
     * Test `getMethod()`
     */
    public function testGetMethod(): void
    {
        $auth = new Token(self::$token);
        $this->assertEquals(self::$method, $auth->getMethod());
    }

    /**
     * Test `getToken()`
     */
    public function testGetToken(): void
    {
        $auth = new Token(self::$token);
        $this->assertEquals(self::$token, $auth->getToken());
    }
}
