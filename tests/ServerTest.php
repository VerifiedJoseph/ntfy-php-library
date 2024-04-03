<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Server;
use Ntfy\Exception\NtfyException;

#[CoversClass(Server::class)]
#[UsesClass(NtfyException::class)]
class ServerTest extends TestCase
{
    /**
     * Test `get()`
     */
    public function testGet(): void
    {
        $server = new Server('https://example.com');
        $this->assertEquals('https://example.com/', $server->get());
    }

    /**
     * Test server URI validator
     */
    public function testServerUriValidator(): void
    {
        $this->expectException(NtfyException::class);
        $this->expectExceptionMessage('Server URI must start with https:// or http://');

        new Server('example.com');
    }
}
