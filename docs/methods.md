# Class methods

## Ntfy

```PHP
Ntfy\Ntfy(Server $server)
```

Class: [Ntfy](../src/Ntfy/Ntfy.php)

### Examples

- [Send a message](../examples/send-message.php)
- [Get sent messages](../examples/get-messages.php)

### Constants

Max message priority

```PHP
Ntfy::PRIORITY_MAX
```

High message priority

```PHP
Ntfy::PRIORITY_HIGH
```

Default message priority

```PHP
Ntfy::PRIORITY_DEFAULT
```

Low message priority

```PHP
Ntfy::PRIORITY_LOW
```

Min message priority

```PHP
Ntfy::PRIORITY_MIN
```

### Methods

Send a message

```PHP
send(
	string $topic,
	string $message,
	string $title = '',
	int $priority = 3,
	string $tags = '',
	string|int $delay = '',
	bool $cache = true
): stdClass
```

 Get sent messages for a topic

```PHP
get(string $topic, mixed $since = 'all'): stdClass
```

## Server
```PHP
Ntfy\Server(string $uri)
```

Class: [Server](../src/Ntfy/Server.php)

### Examples

- [Send a message](../examples/send-message.php)

### Methods

Get a validated server URI

```PHP
get(): string
```