<?php

use Ntfy\Auth;

class AuthTest extends TestCase
{
	protected static Auth $auth;

	protected static string $username = 'admin';
	protected static string $password = 'password123';

	public static function setUpBeforeClass(): void
	{
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
