# Action Classes

## Broadcast

Class for creating an android broadcast button action

```PHP
Ntfy\Action\Broadcast()
```

### Methods

Get action as an array

```PHP
get(): array
```

Set button label

```PHP
label(string $label): void
```

Enable clearing notification after action button is tapped

```PHP
enableNoteClear(): void
```

Set android intent name

```PHP
intent(string $intent): void
```

Set an android intent extra

```PHP
extra($parameter, $value): void
```

## Http

Class for creating a HTTP button action

```PHP
Ntfy\Action\Http()
```

### Methods

Get action as an array

```PHP
get(): array
```

Set button label

```PHP
label(string $label): void
```

Enable clearing notification after action button is tapped

```PHP
enableNoteClear(): void
```

Set HTTP request URL

```PHP
url(string $url): void
```

Set HTTP request method

```PHP
method(string $method): void
```

Set an HTTP request header

```PHP
header(string $name, string $value): void
```

Set HTTP request body

```PHP
body(string $body): void
```

## View

Class for creating a view button action

```PHP
Ntfy\Action\View()
```

### Examples

- [Send message with a view action button](../examples/send-message-with-view-action.php)

### Methods

Get action as an array

```PHP
get(): array
```

Set button label

```PHP
label(string $label): void
```

Enable clearing notification after action button is tapped

```PHP
enableNoteClear(): void
```

Set action URL

```PHP
url(string $url): void
```