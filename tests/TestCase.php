<?php

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @SuppressWarnings(PHPMD.NumberOfChildren)
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
	 * Retruns ntfy server URI
	 *
	 * Return value of `self::$ntfyUri` or environment variable `NTFY_URI` if set.
	 */
	protected static function getNtfyUri(): string
	{
		if (getenv('NTFY_URI') !== false) {
			return getenv('NTFY_URI');
		}

		return self::$ntfyUri;
	}

	/**
	 * Retruns httpbin server URI
	 *
	 * Return value of `self::$gotifyUri` or  environment variable `HTTPBIN_URI` if set.
	 */
	protected static function getHttpBinUri(): string
	{
		if (getenv('HTTPBIN_URI') !== false) {
			return getenv('HTTPBIN_URI');
		}

		return self::$httpBinUri;
	}

	/**
	 * Retruns file attachment image path
	 */
	protected function getImagePath(): string
	{
		$path = __DIR__ . '/TestAssets/image.png';

		$this->assertFileExists($path);

		return $path;
	}
}
