# Authentication Classes

## User

```PHP
Ntfy\Auth\User(string $username, string $password)
```

Class: [User](../../src/Auth/User.php)

### Examples
- [Send a message to a server protected with user authentication](../../examples/send-message-with-user-auth.php)

### Methods

Get authentication method
```PHP
getMethod(): string
```

Get username

```PHP
getUsername(): string
```

Get password

```PHP
getPassword(): string
```

## Token

```PHP
Ntfy\Auth\Token(string $token)
```

Class: [Token](../../src/Auth/Token.php)

### Examples
- [Send a message to a server protected with token authentication](../../examples/send-message-with-token-auth.php)

### Methods

Get authentication method
```PHP
getMethod(): string
```

Get token

```PHP
getToken(): string
```
