# php-sdk

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/bluerocktel/php-sdk.svg?style=flat-square)](https://packagist.org/packages/bluerocktel/php-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/bluerocktel/php-sdk.svg?style=flat-square)](https://packagist.org/packages/bluerocktel/php-sdk)


This package is a light PHP Wrapper / SDK for the [BlueRockTEL](https://bluerocktel.com) Admin API. 

- [Installation](#installation)
- [Authentication](#authentication)
  - [Client Code Grant](#authentication-client-code-grant)
  - [Password Grant](#authentication-password-grant)
- [Usage](#usage)
  - [Requests](#usage-requests)
  - [Resources](#usage-resources)
  - [Responses](#usage-responses)
  - [Entities](#usage-entities)
  - [Pagination](#usage-pagination)


<a name="installation"></a>

## Installation

This library requires PHP `^8.0`.

You can install the package via composer:

```
composer require bluerocktel/php-sdk
```

<a name="authentication"></a>

## Authentication

BlueRockTEL APIs supports OAuth2 for authentication.  
However, this package currently only supports the Password Grant authentication flow.  

<a name="authentication-client-code-grant"></a>

### Client Code Grant

Not supported yet.

<a name="authentication-password-grant"></a>

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

<a name="usage"></a>

## Usage

To query the API, you can either call each API [Endpoints requests](https://github.com/bluerocktel/php-sdk/tree/main/src/Endpoints) individually, or make use of provided [Resources classes](https://github.com/bluerocktel/php-sdk/tree/main/src/Resources) which groups the requests into clusters.


<a name="usage-requests"></a>

### Requests

Using single requests is pretty straightforward. You can use the `call()` method of the `BlueRockTELConnector` class to send the desired request to the instance :

```php
use BlueRockTEL\SDK\BlueRockTELConnector;
use BlueRockTEL\SDK\Endpoints;

$api = new BlueRockTELConnector(BLUEROCKTEL_API_URL, BLUEROCKTEL_API_USERNAME, BLUEROCKTEL_API_PASSWORD);

$response = $api->call(
  new Endpoints\GetVersionRequest()
);

$response = $api->call(
  new Endpoints\Prospects\GetProspectRequest(id: $prospectId)
);
```

<a name="usage-resources"></a>

### Resources

Using resources is a more convenient way to query the API. Each Resource class groups requests by specific API namespaces (Customer, Prospect...).

```php
$query = [
    'filter' => [
        'name' => 'Acme Enterprise',
        'term_match' => 'PR0001'
    ],
    'sort' => '-created_at',
];

$response = $api->prospect()->index(
    query: $query,
    perPage: 20,
    page: 1,
);
```

Resources classes usually provide (but are not limited to) the following methods :

```php
class NamespaceResource
{
    public function index(array $query = [], int $perPage = 20, int $page = 1): Response;
    public function show($id): Response;
    public function store(Entity $entity): Response;
    public function update(Entity $entity): Response;
    public function save(Entity $entity): Response;
    public function delete(Entity $entity): Response;
}
```

> 👉 The `save()` method is a simple alias : it will call the `update()` method if the given entity has an id, or the `store()` method otherwise.  

Each of those namespace resources can be accessed using the `BlueRockTELConnector` instance :

```php
(new BlueRockTELConnector(...))->note(): Resources\NoteResource
(new BlueRockTELConnector(...))->prospect(): Resources\ProspectResource
(new BlueRockTELConnector(...))->customerFile(): Resources\CustomerFileResource
...
```

If needed, it is also possible to create the desired resource instance manually :

```php
use BlueRockTEL\SDK\BlueRockTELConnector;
use BlueRockTEL\SDK\Resources\ProspectResource;

$api = new BlueRockTELConnector(...);
$resource = new ProspectResource($api);
$resource->save($prospect);
```

<a name="usage-responses"></a>

### Responses

Weither you are using Requests or Resources, the response is always an instance of `Saloon\Http\Response` class.  
It provides some useful methods to check the response status and get the response data.

```php
// Check response status
$response->ok();
$response->failed();
$response->status();
$response->headers();

// Get response data
$response->json(); # as an array
$response->body(); # as an raw string
$response->dtoOrFail(); # as a Data Transfer Object
```

You can learn more by reading the [Saloon documentation](https://docs.saloon.dev/the-basics/responses#available-methods), which this SDK uses underneath.  

<a name="usage-entities"></a>

### Entities (DTO)

When working with APIs, sometimes dealing with a raw response or a JSON response can be tedious and unpredictable.  

To make it easier, this SDK provides a way to transform the response data into a Data Transfer Object (DTO), later called "Entities".

```php
$response = $api->prospect()->show(id: 92);

// returns: \BlueRockTEL\SDK\Entities\Prospect
$response->dto();
$response->dtoOrFail();
```


Although you can use the `dto()` method to transform the response data into an entity, it is recommended to use the `dtoOrFail()` method instead. This method will throw an exception if the response status is not 2xx, instead of returning an empty DTO.

It is still possible to access the underlying response object using the `getResponse()` method of the DTO :

```php
$entity = $response->dtoOrFail();   // \BlueRockTEL\SDK\Contracts\Entity
$entity->getResponse();             // \Saloon\Contracts\Response
```

Learn more about DTO and their features on the [Saloon documentation](https://docs.saloon.dev/the-basics/data-transfer-objects).

The create/update/delete routes will often ask for a DTO as first parameter :

```php
use BlueRockTEL\SDK\Entities\Prospect;

// create
$response = $api->prospect()->store(
    new Prospect(
        name: 'Acme Enterprise',
        customerAccount: 'PR0001',
    )
);

$prospect = $response->dtoOrFail();
saveProspectId($prospect->id); // save id locally for later use

// update
$prospect->name = 'Acme Enterprise Inc.';
$api->prospect()->update($prospect);

// delete
$api->prospect()->delete(new Prospect(
    id: 1234,
));
```


<a name="usage-pagination"></a>

### Pagination

On some index/search routes, the API response will use a pagination. If you need to iterate on all pages of the endpoint, you can use the handy connector's `paginate()` method :

```php
$query = [
  'sort' => 'created_at',
];

# Create a PagedPaginator instance
$paginator = $api->paginate(
  new GetProspectsRequest($query),
  perPage: 10,
);

# Iterate on entities (using lazy loading)
foreach ($paginator as $page) {
    foreach ($page->dtoOrFail() as $prospect) {
        // ...
    }
}

# Iterate on raw arrays (using lazy loading)
foreach ($paginator->json('data') as $prospects) {
    foreach ($prospects as $prospect) {
        // ...
    }
}
```

Of course, the paginator can also be controlled manually :

```php
while ($paginator->valid()) {
    $response = $paginator->current();
    $entities = $response->dtoOrFail();
    // ...
    $paginator->next();
}
```

Read more about pagination on the [Saloon documentation](https://docs.saloon.dev/digging-deeper/pagination).