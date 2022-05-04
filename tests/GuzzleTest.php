<?php

use Ntfy\Guzzle;
use Ntfy\Json;

class GuzzleTest extends TestCase
{
	private static Guzzle $guzzle;

	public static function setUpBeforeClass(): void
	{
		self::$guzzle = new Guzzle(self::getHttpBinUri());
	}

	/**
	 * Test making a GET request
	 */
	public function testGet(): void
	{
		$query = array(
			'test' => 'HelloWorld'
		);

		$response = self::$guzzle->get('get', $query);
		$body = (object) Json::decode($response->getBody());

		$this->assertIsObject($body);
		$this->assertObjectHasAttribute('args', $body);
		$this->assertObjectHasAttribute('test', $body->args);
		$this->assertEquals('HelloWorld', $body->args->test);
	}

	/**
	 * Test making a POST request
	 */
	public function testPost(): void
	{
		$data = ['hello' => 'World'];
		$headerValue = 'hello world';

		$headers = array(
			'X-Httpbin-Test' => $headerValue
		);

		$response = self::$guzzle->post('post', $data, $headers);
		$body = (object) Json::decode($response->getBody());

		$this->assertIsObject($body);
		$this->assertObjectHasAttribute('data', $body);
		$this->assertObjectHasAttribute('headers', $body);
		$this->assertObjectHasAttribute('X-Httpbin-Test', $body->headers);

		$this->assertEquals($data, (array) $body->json);
		$this->assertEquals($headerValue, $body->headers->{'X-Httpbin-Test'});
	}

	/**
	 * Test making a PUT request with a file
	 */
	public function testPutFile(): void
	{
		$response = self::$guzzle->putFile('put', $this->getImagePath());
		$body = (object) Json::decode($response->getBody());

		$this->assertIsObject($body);
		$this->assertObjectHasAttribute('data', $body);
	}
}
