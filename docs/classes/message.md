# Message

Class for sending a message

```PHP
Ntfy\Message()
```

### Examples

- [Send a message](../../examples/send-message.php)
- [Send a message with a view action button](../../examples/send-message-with-view-action.php)

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
priority(int $priority): void
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
schedule(string $delay): void
```

Set URL to open when message notification is clicked

```PHP
clickAction(string $url): void
```

Set email address for sending a email notification

```PHP
email(string $email): void
```

Set URL for message notification icon

```PHP
icon(string $url): void
```

Set a file attachment using a URL

```PHP
attachURL(string $url, string $name = ''): void
```

Set an action button

```PHP
action(Action $action): void
```

Disable caching for this message

```PHP
disableCaching(): void
```

Disable firebase for this message

```PHP
disableFirebase(): void
```

Get the data to be sent as JSON to the server.

```PHP
getData(): array
```
