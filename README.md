# ntfy-php-library

[![Latest Version](https://img.shields.io/github/release/VerifiedJoseph/ntfy-php-library.svg?style=flat-square)](https://github.com/VerifiedJoseph/ntfy-php-library/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

PHP library for sending messages using a [ntfy](https://github.com/binwiederhier/ntfy) server.

Supports ntfy server version 1.26.0.

## Install

```
composer require verifiedjoseph/ntfy-php-library
```

## Quick Start
```PHP
require __DIR__ . '/vendor/autoload.php';

use Ntfy\Server;
use Ntfy\Message;

$server = new Server('https://ntfy.sh/');
$message = new Message($server);

$message->topic('mytopic');
$message->title('Hello World');
$message->body('Hello World from ntfy.sh');
$message->priority(Message::PRIORITY_HIGH);

$message->send();
```

## Documentation

- [Classes](docs/README.md)
- [Exceptions](docs/exceptions.md)
- [Code examples](docs/examples.md)

## Requirements

- PHP >= 8.0
- Composer
- PHP Extensions:
  - [`JSON`](https://www.php.net/manual/en/book.json.php)
  - [`cURL`](https://secure.php.net/manual/en/book.curl.php)

## Dependencies

[`guzzlehttp/guzzle`](https://github.com/guzzle/guzzle/)

## Changelog

All notable changes to this project are documented in the [CHANGELOG](CHANGELOG.md).

## License

MIT License. Please see [LICENSE](LICENSE) for more information.
