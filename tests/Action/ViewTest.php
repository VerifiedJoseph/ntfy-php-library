<?php

use PHPUnit\Framework\Attributes\CoversClass;
use Ntfy\Action\View;

#[CoversClass(View::class)]
#[CoversClass(Ntfy\Action::class)]
class ViewTest extends TestCase
{
    /**
     * Test creating an broadcast action
     */
    public function testAction(): void
    {
        $config = [
            'action' => 'view',
            'label' => 'Open Website',
            'url' => 'https://example.com',
            'clear' => true,
        ];

        $action = new Ntfy\Action\View();
        $action->label($config['label']);
        $action->url($config['url']);
        $action->enableNoteClear();

        $this->assertEquals($config, $action->get());
    }
}
