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
	 * @param array<mixed> $data
	 * @return string
	 *
	 * @throws NtfyException if array could not be encoded
	 */
	static function encode(array $data): string
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
	 * @return stdClass|array<mixed>
	 *
	 * @throws NtfyException if JSON could not be decoded
	 */
	public static function decode(string $json): stdClass|array
	{
		try {
			$decoded = json_decode($json, flags: JSON_THROW_ON_ERROR);

			if (is_array($decoded)) {
				return (array) $decoded;

			} else {
				return (object) $decoded;
			}
		} catch (JsonException $err) {
			throw new NtfyException('JSON Error: ' . $err->getMessage());
		}
	}
}
