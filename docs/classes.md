# Classes

## Server

Class for setting and vaildating a server URI

```PHP
Ntfy\Server(string $uri)
```

### Examples

- [Send a message](../examples/send-message.php)

### Methods

Get server URI

```PHP
get(): string
```

## Message

Class for sending a message

```PHP
Ntfy\Message(Server $server)
```

### Examples

- [Send a message](../examples/send-message.php)
- [Send a message with a file attachment](../examples/send-message-with-file-attachment.php)

### Constants

Maximum message priority

```PHP
Message::PRIORITY_MAX
```

High message priority

```PHP
Message::PRIORITY_HIGH
```

Default message priority

```PHP
Message::PRIORITY_DEFAULT
```

Low message priority

```PHP
Message::PRIORITY_LOW
```

Minimum message priority

```PHP
Message::PRIORITY_MIN
```

### Methods

Set message topic

```PHP
topic(string $topic): void
```

Set message title

```PHP
title(string $title): void
```

Set message priority

```PHP
priority(string|int $priority): void
```

Set message body

```PHP
body(string $body): void
```

Set message tags

```PHP
tags(array $tags): void
```

Set scheduled delivery for the message

```PHP
schedule(string|int $delay): void
```

Set URL to open when message notification is clicked

```PHP
clickAction(string $url): void
```

Set email address for sending a email notification

```PHP
email(string $email): void
```

Set a file attachment using a local file

```PHP
attach(string $file, string $filename = ''): void
```

Set a file attachment using a URL

```PHP
attachURL(string $url): void
```

Disable caching for this message

```PHP
disableCaching(): void
```

Disable firebase for this message

```PHP
disableFirebase(): void
```

Send the message

```PHP
send(): stdClass
```
