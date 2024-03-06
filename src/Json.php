<?php

namespace Ntfy;

use stdClass;
use JsonException;
use Ntfy\Exception\NtfyException;

/**
 * Class for encoding and decoding JSON
 */
final class Json
{
    /**
     * Encode JSON
     *
     * @param mixed $data
     * @return string
     *
     * @throws NtfyException if data could not be encoded
     */
    public static function encode(mixed $data): string
    {
        try {
            return json_encode($data, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $err) {
            throw new NtfyException('JSON Error: ' . $err->getMessage());
        }
    }

    /**
     * Decode JSON
     *
     * @param string $json
     * @return stdClass
     *
     * @throws NtfyException if JSON could not be decoded
     */
    public static function decode(string $json): stdClass
    {
        try {
            return json_decode($json, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $err) {
            throw new NtfyException('JSON Error: ' . $err->getMessage());
        }
    }
}
