# php-sdk

This library a light PHP wrapper for the [BlueRockTEL](https://bluerocktel.com) Admin API. 

## Installation

This library requires PHP `^8.0`.

You can install the package via composer:

```
composer require bluerocktel/php-sdk
```

## Authentication

The BlueRockTEL API uses OAuth2 for authentication. However, the package currently only supports the Password Grant authentication flow.

### Client Code Grant

// Soon.

### Password Grant

The SDK allows you to connect using your usual credentials. To get started, first iniate the `BlueRockTELConnector` class : 

```php
use BlueRockTEL\SDK\BlueRockTELConnector;

$api = new BlueRockTELConnector(
  'https://telecom0xxx-admin.bluerocktel.net/api/',
  'developers@bluerocktel.com',
  'secret',
);
```

If the provided credentials are not correct, a `BlueRockTEL\SDK\Exceptions\AuthenticationException` will be thrown.

You can test the connection by calling the `version` method :

```php
$response = $api->helper()->version();

var_dump(
  $response->failed(), // true is the request returned 4xx or 5xx code.
  $response->json(),   // json response as an array
);
```

## Usage

You can either call API Endpoint request individually or use Resources.


```php
$query = [
    'filter' => [
        'name' => 'Acme Enterprise',
        'term_match' => 'PR0001'
    ],
    'sort' => 'created_at',
];

$response = $api->prospect()->index(
    query: $query,
    perPage: 10,
);

// Check response status...
$response->ok();
$response->failed();
$response->status();

// Get response data as an array...
$response->json();

```