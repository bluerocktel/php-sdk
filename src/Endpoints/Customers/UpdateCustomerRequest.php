<?php

namespace BlueRockTEL\SDK\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Customer;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class UpdateCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v1/customers/' . $this->customer->id;
    }

    public function __construct(
        protected Customer $customer,
    ) {
        if (!$this->customer->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->customer->toArray(filter: true),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Customer::fromResponse($response);
    }
}