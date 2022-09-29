# Exceptions

When the library encounters an error it will always throw an exception. Your code must catch the exceptions listed below.

## NtfyException
```PHP
Ntfy\Exception\NtfyException
```

Thrown when the ntfy library experiences an error.

Example: [`Ntfy\Server`](../src/Server.php) will throw `NtfyException` if the given server URI is invalid.

## EndpointException 
```PHP
Ntfy\Exception\EndpointException
```

Thrown when the ntfy server returns an error.