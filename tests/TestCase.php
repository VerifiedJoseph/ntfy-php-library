<?php

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
	 * Load fixture
	 */
	protected static function loadFixture(string $name): string
	{
		$fixturePath = __DIR__ . '/Fixtures/' . $name;
		$contents = file_get_contents($fixturePath);

		if ($contents === false) {
			throw new RuntimeException(sprintf('Unable to load fixture: %s', $fixturePath));
		}

		return $contents;
	}
}
