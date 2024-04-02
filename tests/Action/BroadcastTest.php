<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Action\Broadcast;

#[CoversClass(Broadcast::class)]
#[UsesClass(Ntfy\Action::class)]
class BroadcastTest extends TestCase
{
    /**
     * Test creating an broadcast action
     */
    public function testAction(): void
    {
        $config = [
            'action' => 'broadcast',
            'label' => 'Take picture',
            'intent' => 'com.example.AN_INTENT',
            'extras' => [
                'cmd' => 'pic',
                'camera' => 'front'
            ],
            'clear' => true,
        ];

        $action = new Broadcast();
        $action->label($config['label']);
        $action->intent($config['intent']);

        foreach ($config['extras'] as $parameter => $value) {
            $action->extra($parameter, $value);
        }

        $action->enableNoteClear();

        $this->assertEquals($config, $action->get());
    }
}
