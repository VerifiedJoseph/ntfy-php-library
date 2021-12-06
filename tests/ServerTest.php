<?php

class ServerTest extends TestCase
{
	/**
	 * Test server URI validator
	 */
	public function testServerUriValidator(): void
	{
		$this->expectException(Ntfy\Exception\NtfyException::class);

		$server = new Ntfy\Server('127.0.0.1');
	}
}
