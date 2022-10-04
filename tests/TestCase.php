<?php

use stdClass;
use Ntfy\Json;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 */
abstract class TestCase extends BaseTestCase
{
	protected static string $ntfyUri = 'http://127.0.0.1:8080/';
	protected static string $httpBinUri = 'https://httpbin.org/';

	protected static Ntfy\Server $server;

	public static function setUpBeforeClass(): void
	{
		self::$server = new Ntfy\Server(self::getNtfyUri());
	}

	/**
	 * Returns ntfy server URI
	 *
	 * Returns value of `self::$ntfyUri` or environment variable `NTFY_URI` if set.
	 */
	protected static function getNtfyUri(): string
	{
		if (getenv('NTFY_URI') !== false) {
			return getenv('NTFY_URI');
		}

		return self::$ntfyUri;
	}

	/**
	 * Returns httpbin server URI
	 *
	 * Returns value of `self::$httpBinUri` or environment variable `HTTPBIN_URI` if set.
	 */
	protected static function getHttpBinUri(): string
	{
		if (getenv('HTTPBIN_URI') !== false) {
			return getenv('HTTPBIN_URI');
		}

		return self::$httpBinUri;
	}

	/**
	 * Returns example message values loaded from message.json
	 */
	protected static function getMessageExample(): stdClass
	{
		$data = (string) file_get_contents('TestAssets/message.json');
		return Json::decode($data);
	}

	/**
	 * Returns example action values loaded from action.json
	 */
	protected static function getActionExample(): stdClass
	{
		$data = (string) file_get_contents('TestAssets/action.json');
		return Json::decode($data);
	}
}
