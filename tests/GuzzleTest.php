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
	 * Test making a GET request with Basic Auth
	 */
	public function testBasicAuth(): void
	{
		$auth = [
			'username' => 'admin',
			'password' => 'pasword1245'
		];

		$guzzle = new Guzzle(self::getHttpBinUri(), $auth);

		$response = $guzzle->get('basic-auth/' . $auth['username'] . '/' . $auth['password']);
		$body = (object) Json::decode($response->getBody());

		$this->assertIsObject($body);
		$this->assertObjectHasAttribute('authenticated', $body);
		$this->assertObjectHasAttribute('user', $body);

		$this->assertEquals(true, $body->authenticated);
		$this->assertEquals($auth['username'], $body->user);
	}
}
