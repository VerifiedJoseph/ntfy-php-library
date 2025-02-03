<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use Ntfy\Action\View;

#[CoversClass(View::class)]
#[CoversClass(Ntfy\Action\AbstractAction::class)]
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

        $action = new View();
        $action->label($config['label']);
        $action->url($config['url']);
        $action->enableNoteClear();

        $this->assertEquals($config, $action->get());
    }
}
