<?php

namespace BlueRockTEL\SDK\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Response;
use BlueRockTEL\SDK\EntityCollection;
use BlueRockTEL\SDK\Entities\Customer;

class GetCustomersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/customers';
    }

    public function __construct(
        protected array $params = [],
        protected int $perPage = 20,
        protected int $page = 1,
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'page' => $this->page,
            'per_page' => $this->perPage,
        ], $this->params);
    }

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, Customer::class, 'data');
    }
}