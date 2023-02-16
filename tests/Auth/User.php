<?php

use Ntfy\Auth\User;

class AuthUserTest extends TestCase
{
    protected static User $auth;

    protected static string $method = 'user';
    protected static string $username = 'admin';
    protected static string $password = 'password123';

    public static function setUpBeforeClass(): void
    {
        self::$auth = new User(self::$username, self::$password);
    }

    /**
     * Test `getMethod()`
     */
    public function testGetMethod(): void
    {
        $this->assertEquals(self::$method, self::$auth->getMethod());
    }

    /**
     * Test `getUsername()`
     */
    public function testGetUsername(): void
    {
        $this->assertEquals(self::$username, self::$auth->getUsername());
    }

    /**
     * Test `getPassword()`
     */
    public function testGetPassword(): void
    {
        $this->assertEquals(self::$password, self::$auth->getPassword());
    }
}
