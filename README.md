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

To query the API, you can either call each API [Endpoints requests](https://github.com/bluerocktel/php-sdk/tree/main/src/Endpoints) individually, or make use of provided [Resources](https://github.com/bluerocktel/php-sdk/tree/main/src/Resources) which groups the requests into clusters.


### Requests

Using request is pretty straightforward. You can use the `call()` method of the `BlueRockTELConnector` class to send the desired request :

```php
use BlueRockTEL\SDK\Endpoints\GetVersionRequest;
use BlueRockTEL\SDK\Endpoints\Prospects\GetProspectRequest;

$api = new BlueRockTELConnector(BLUEROCKTEL_API_URL, BLUEROCKTEL_API_USERNAME, BLUEROCKTEL_API_PASSWORD);

$response = $api->call(new GetVersionRequest());
$response = $api->call(new GetProspectRequest(id: $prospectId));
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
    perPage: 20,
    page: 1,
);
```

Resources usually provide the following methods :

```php
public function index(array $query = [], int $perPage = 20, int $page = 1): Response;
public function show($id): Response;
public function store(Prospect $prospect): Response;
public function update(Prospect $prospect): Response;
public function save(Prospect $prospect): Response;
public function delete(Prospect $prospect): Response;
```

> The save() method is an alias, it will call the update() method if the DTO has an id, and the store() method otherwise.  


### Response

In both cases, the response is an instance of `BlueRockTEL\SDK\Responses\Response` class. It provides some useful methods to check the response status and get the response data.

```php
// Check response status
$response->ok();
$response->failed();
$response->status();

// Get response data
$response->json(); # as an array
$response->body(); # as an raw string
$response->dtoOrFail(); # as a Data Transfer Object
```

You can learn more reading the [Saloon documentation](https://docs.saloon.dev/the-basics/responses#available-methods), which this SDK is using underneath.

### DTO

When working with APIs, sometimes dealing with a raw response or a JSON response can be tedious and unpredictable.
To make it easier, this SDK provides a way to transform the response data into a Data Transfer Object (DTO).

```php
$response = $api->prospect()->show(id: 92);

$response->dto();
$response->dtoOrFail();
```

Altrough you can use the `dto()` method to transform the response data into a DTO, it is recommended to use the `dtoOrFail()` method instead. This method will throw an exception if the response status is not 2xx, instead of returning an empty DTO.

It is still possible to access the underlying response object using the `getResponse()` method of the DTO :

```php
$entity = $response->dtoOrFail();   // \BlueRockTEL\SDK\Contracts\Entity
$entity->getResponse();             // \Saloon\Contracts\Response
```

Learn more about DTO and their functionnalities on the [Saloon documentation](https://docs.saloon.dev/the-basics/data-transfer-objects).

The create/update/delete route will often ask for a DTO as a parameter :

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

saveProspectId($prospect->id);

// update
$prospect->name = 'Acme Enterprise Inc.';
$api->prospect()->update($prospect);

// delete
$api->prospect()->delete(new Prospect(
    id: 1234,
));
```


### Pagination

On some index/search routes, the response will provide a Pagination. If you need to iterate on all the results available on the endpoint, you can use the connector's `paginate()` method :

```php
$query = [
  'sort' => 'created_at',
];

# Create a PagedPaginator instance
$paginator = $api->paginate(
  new GetProspectsRequest($query),
  perPage: 10,
);

# Access current page data
$current = $paginator->current()->json();

# Iterate using lazy loading
foreach ($paginator->json('data') as $prospects) {
    foreach($prospects as $prospect) {
        // ...
    }
}

// foreach ($paginator->dtoOrFail() as $prospect) // using DTO
```

Of course, the paginator can be used manually :

```php
while ($paginator->valid()) {
    $data = $paginator->current()->json();
    // ...
    $paginator->next();
}
```

Read more about paginator on the [Saloon documentation](https://docs.saloon.dev/digging-deeper/pagination).