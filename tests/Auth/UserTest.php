<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Auth\User;
use Ntfy\Json;

#[CoversClass(User::class)]
#[CoversClass(Ntfy\Auth\AbstractAuth::class)]
#[UsesClass(Json::class)]
class UserTest extends TestCase
{
    protected static string $method = 'user';
    protected static string $username;
    protected static string $password;

    public static function setUpBeforeClass(): void
    {
        $fixture = Json::decode(self::loadAsset('auth.json'));
        self::$username = $fixture->username;
        self::$password = $fixture->password;
    }

    /**
     * Test `getMethod()`
     */
    public function testGetMethod(): void
    {
        $auth = new User(self::$username, self::$password);
        $this->assertEquals(self::$method, $auth->getMethod());
    }

    /**
     * Test `getUsername()`
     */
    public function testGetUsername(): void
    {
        $auth = new User(self::$username, self::$password);
        $this->assertEquals(self::$username, $auth->getUsername());
    }

    /**
     * Test `getPassword()`
     */
    public function testGetPassword(): void
    {
        $auth = new User(self::$username, self::$password);
        $this->assertEquals(self::$password, $auth->getPassword());
    }
}
