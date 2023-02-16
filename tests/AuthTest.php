<?php

use Ntfy\Json;
use Ntfy\Auth;

class AuthTest extends TestCase
{
    protected static Auth $auth;

    protected static string $username;
    protected static string $password;

    public static function setUpBeforeClass(): void
    {
        $fixture = Json::decode(self::loadFixture('auth.json'));
        self::$username = $fixture->username;
        self::$password = $fixture->password;

        self::$auth = new Auth(self::$username, self::$password);
    }

    /**
     * Test get username
     */
    public function testGetUsername(): void
    {
        $this->assertEquals(self::$username, self::$auth->getUsername());
    }

    /**
     * Test get password
     */
    public function testGetPassword(): void
    {
        $this->assertEquals(self::$password, self::$auth->getPassword());
    }
}
