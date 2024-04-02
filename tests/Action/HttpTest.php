<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Action\Http;

#[CoversClass(Http::class)]
#[UsesClass(Ntfy\Action::class)]
class HttpTest extends TestCase
{
    /**
     * Test creating an HTTP action
     */
    public function testAction(): void
    {
        $config = [
            'action' => 'http',
            'label' => 'Open Website',
            'url' => 'https://example.com',
            'method' => 'POST',
            'headers' => [
                'x-test' => 'Hello World',
                'x-test-two' => 'PHP unit text'
            ],
            'body' => 'Hello World',
            'clear' => true,
        ];

        $action = new Ntfy\Action\Http();
        $action->label($config['label']);
        $action->url($config['url']);
        $action->method($config['method']);

        foreach ($config['headers'] as $name => $value) {
            $action->header($name, $value);
        }

        $action->body($config['body']);
        $action->enableNoteClear();

        $this->assertEquals($config, $action->get());
	}
}
