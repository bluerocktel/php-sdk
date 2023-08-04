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

soon...

### Password Grant

To connect using your usual BlueRockTEL credentials, first initiate the `BlueRockTELConnector` class providing your instance URL, email and password : 

```php
use BlueRockTEL\SDK\BlueRockTELConnector;

$api = new BlueRockTELConnector(
  'https://telecom0xxx-admin.bluerocktel.net/api/',
  'developers@bluerocktel.com',
  'secret',
);
```

If the connector fails to retrive a Bearer token from the provided credentials, a `BlueRockTEL\SDK\Exceptions\AuthenticationException` will be thrown.

Otherwise, you can start testing the API by calling the `version()` method of Helper resource :

```php
$response = $api->helper()->version();

var_dump(
  $response->failed(), // true is the request returned 4xx or 5xx code.
  $response->json(),   // json response as an array
);
```

## Usage

To query the API, you can either call each API [Endpoints requests](https://github.com/bluerocktel/php-sdk/tree/main/src/Endpoints) individually, or make use of the provided [Resources](https://github.com/bluerocktel/php-sdk/tree/main/src/Resources) grouping the requests into groups.


### Requests

Using request is pretty straightforward. You can use the `call()` method of the `BlueRockTELConnector` class to send the desired request :

```php
$api = new BlueRockTELConnector(BRT_API_URL, BRT_API_USERNAME, BRT_API_PASSWORD);

$response = $api->call(new GetVersionRequest());
$response = $api->call(new GetProspectRequest($prospectId));
```


### Resources

Using resources is a more convenient way to query the API. Each resource is a class grouping the requests related to a specific API endpoint.

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
```

### Response

In both cases, the response is an instance of `BlueRockTEL\SDK\Responses\Response` class. It provides some useful methods to check the response status and get the response data.

```php
// Check response status...
$response->ok();
$response->failed();
$response->status();

// Get response data...
$response->json(); # as an array
$response->body(); # as an raw string
```

You can learn more reading the [Saloon](https://docs.saloon.dev/the-basics/responses#available-methods) documentation, which this SDK is using underneath.

### Pagination

todo