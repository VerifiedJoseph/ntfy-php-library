<?php

use Ntfy\Json;
use Ntfy\Exception\NtfyException;

class JsonTest extends TestCase
{
    public function testEncodeValid(): void
    {
        self::assertEquals('{"foo":"bar"}', Json::encode(['foo' => 'bar']));
    }

    public function testDecodeValid(): void
    {
        $expected = new stdClass();
        $expected->foo = 'bar';
        self::assertEquals($expected, Json::decode('{"foo": "bar"}'));
    }

    public function testEncodeInvalid(): void
    {
        $this->expectException(NtfyException::class);
        $this->expectExceptionMessage('JSON Error: Malformed UTF-8 characters, possibly incorrectly encoded');
        Json::encode("\xB1\x31");
    }

    public function testDecodeInvalid(): void
    {
        $this->expectException(NtfyException::class);
        $this->expectExceptionMessage('JSON Error: Syntax error');
        Json::decode('foo');
    }
}
