<?php

namespace Ntfy;

class Auth
{
	private string $username;

	private string $password;

	public function __construct(string $username, string $password)
	{
		$this->username = $username;
		$this->password = $password;
	}


	/**
	 * @return array<string, string>
	 */
	public function get(): array
	{
		return [
			'username' => $this->username,
			'password' => $this->password,
		];
	}

}
