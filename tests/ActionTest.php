<?php

use Ntfy\Action;

class ActionTest extends TestCase
{
	/**
	 * Test action broadcast creation
	 */
	public function testBroadcastAction(): void
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

		$action = new Ntfy\Action\Broadcast();
		$action->label($config['label']);
		$action->intent($config['intent']);

		foreach ($config['extras'] as $parameter => $value) {
			$action->extra($parameter, $value);
		}

		$action->enableNoteClear();

		$this->assertEquals($config, $action->get());
	}

	/**
	 * Test action HTTP creation
	 */
	public function testHttpAction(): void
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

	/**
	 * Test action view creation
	 */
	public function testViewAction(): void
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
