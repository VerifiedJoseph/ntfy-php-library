<?php

declare(strict_types=1);

/**
 * Class TestCase
 */
abstract class TestCase extends PHPUnit\Framework\TestCase
{
    protected static string $ntfyUri = 'http://127.0.0.1:8080/';
    protected static string $httpBinUri = 'https://httpbin.org/';

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
     * Load test assets
     */
    protected static function loadAsset(string $name): string
    {
        $fixturePath = __DIR__ . '/TestAssets/' . $name;
        $contents = file_get_contents($fixturePath);

        if ($contents === false) {
            throw new RuntimeException(sprintf('Unable to load asset: %s', $fixturePath));
        }

        return $contents;
    }
}
