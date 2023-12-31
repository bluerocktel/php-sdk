<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Contracts\Response;
use BlueRockTEL\SDK\Entities\Customer;
use BlueRockTEL\SDK\Endpoints\Customers as Endpoints;

class CustomerResource extends Resource
{
    public function index(
        array $query = [],
        int $perPage = 20,
        int $page = 1,
    ): Response {
        return $this->connector->send(
            new Endpoints\GetCustomersRequest(
                params: $query,
                perPage: $perPage,
                page: $page,
            )
        );
    }

    public function show($id): Response
    {
        return $this->connector->send(
            new Endpoints\GetCustomerRequest($id)
        );
    }

    public function store(Customer $customer): Response
    {
        return $this->connector->send(
            new Endpoints\CreateCustomerRequest($customer)
        );
    }

    public function update(Customer $customer): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateCustomerRequest($customer)
        );
    }

    public function save(Customer $customer): Response
    {
        return $customer->id
            ? $this->update($customer)
            : $this->store($customer);
    }

    public function delete(Customer $customer): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteCustomerRequest($customer)
        );
    }
}