<?php

namespace BlueRockTEL\SDK\Endpoints\Customers;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Customer;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class DeleteCustomerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v1/customers/' . $this->customer->id;
    }

    public function __construct(
        protected Customer $customer,
    ) {
        if (!$this->customer->id) {
            throw new EntityIdMissingException('Entity must have an ID to be deleted.');
        }
    }
}