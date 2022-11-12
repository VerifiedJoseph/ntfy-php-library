<?php

use Ntfy\Server;
use Ntfy\Exception\NtfyException;

class ServerTest extends TestCase
{
    /**
     * Test server URI validator
     */
    public function testServerUriValidator(): void
    {
        $this->expectException(NtfyException::class);
        $this->expectExceptionMessage('Server URI must start with https:// or http://');

        $server = new Server('example.com');
    }
}
