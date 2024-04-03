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
  - [Extending the SDK](#usage-extends)


<a name="installation"></a>

## Installation

This library requires PHP `>=8.1`.

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
  'https://telecomxxxx-admin.bluerocktel.net/api/',
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

### Using Requests

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

### Using Resources

Using resources is a more convenient way to query the API. Each Resource class groups requests by specific API namespaces (Customer, Prospect...).

```php
use BlueRockTEL\SDK\BlueRockTELConnector;

$api = new BlueRockTELConnector(BLUEROCKTEL_API_URL, BLUEROCKTEL_API_USERNAME, BLUEROCKTEL_API_PASSWORD);

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
    public function index(array $params = [], int $perPage = 20, int $page = 1): Response;
    public function show(int $id): Response;
    public function store(Entity $entity): Response;
    public function update(Entity $entity): Response;
    public function upsert(Entity $entity): Response;
    public function delete(int $id): Response;
}
```

> 👉 The `upsert()` method is a simple alias : it will call the `update()` method if the given entity has an id, or the `store()` method if not.

Each of those namespace resources can be accessed using the `BlueRockTELConnector` instance :

```php
$connector = new BlueRockTELConnector(...);

$connector->note(): Resources\NoteResource
$connector->prospect(): Resources\ProspectResource
$connector->customerFile(): Resources\CustomerFileResource
...
```

If needed, it is also possible to create the desired resource instance manually.

```php
use BlueRockTEL\SDK\BlueRockTELConnector;
use BlueRockTEL\SDK\Resources\ProspectResource;

$api = new BlueRockTELConnector();
$resource = new ProspectResource($api);

$prospect = $resource->show($prospectId);
$resource->upsert($prospect);
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

You can learn more about responses by reading the [Saloon documentation](https://docs.saloon.dev/the-basics/responses#useful-methods), which this SDK uses underneath.

<a name="usage-entities"></a>

### Entities (DTO)

When working with APIs, dealing with a raw or JSON response can be tedious and unpredictable.

To make it easier, this SDK provides a way to transform the response data into a Data Transfer Object (DTO) (later called Entities). This way, you are aware of the structure of the data you are working with, and you can access the data using object typed properties instead of untyped array keys.


```php
$response = $api->prospect()->show(id: 92);

/** @var \BlueRockTEL\SDK\Entities\Prospect */
$prospect = $response->dtoOrFail();
```


Although you can use the `dto()` method to transform the response data into an entity, it is recommended to use the `dtoOrFail()` method instead. This method will throw an exception if the response status is not 2xx, instead of returning an empty DTO.

It is still possible to access the underlying response object using the `getResponse()` method of the DTO :

```php
$entity = $response->dtoOrFail();   // \BlueRockTEL\SDK\Contracts\Entity
$entity->getResponse();             // \Saloon\Http\Response
```

> Learn more about working with Data tranfert objects on the [Saloon documentation](https://docs.saloon.dev/digging-deeper/data-transfer-objects).

The create/update/upsert routes will often ask for a DTO as first parameter :

```php
use BlueRockTEL\SDK\Entities\Prospect;

// create
$response = $api->prospect()->store(
    prospect: new Prospect(
        name: 'Acme Enterprise',
        customerAccount: 'PR0001',
    ),
);

$prospect = $response->dtoOrFail();

// update
$prospect->name = 'Acme Enterprise Inc.';
$api->prospect()->update($prospect);
```


<a name="usage-pagination"></a>

### Pagination

On some index/search routes, the BlueRockTEL API will use a pagination.
If you need to iterate on all pages of the endpoint, you may find handy to use the connector's `paginate()` method :

```php
$query = [
  'sort' => 'created_at',
];

# Create a PagedPaginator instance
$paginator = $api->paginate(new GetProspectsRequest($query));

# Iterate on all pages entities, using lazy loading for performance
foreach ($paginator->items() as $prospect) {
    $name = $prospect->name;
    $customerAccount = $prospect->customerAccount;
}
```

Read more about lazy paginations on the [Saloon documentation](https://docs.saloon.dev/installable-plugins/pagination#using-the-paginator).

<a name="usage-extends"></a>

### Extending the SDK

You may easily extend the SDK by creating your own Resources, Requests, and Entities.

Then, by extending the `BlueRockTELConnector` class, add you new resources to the connector :

```php
use BlueRockTEL\SDK\BlueRockTELConnector;

class MyCustomConnector extends BlueRockTELConnector
{
    public function defaultConfig(): array
    {
        return [
            'timeout' => 120,
        ];
    }

    public function customResource(): \App\Resources\CustomResource
    {
        return new \App\Resources\CustomResource($this);
    }
}

$api = new MyCustomConnector(BLUEROCKTEL_API_URL, BLUEROCKTEL_API_USERNAME, BLUEROCKTEL_API_PASSWORD);
$api->customResource()->index();
```
