<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\PhoneCall;
use BlueRockTEL\SDK\Endpoints\PhoneCalls as Endpoints;

class PhoneCallResource extends Resource
{
    public function index(
        array $params = [],
        int $perPage = 20,
        int $page = 1,
    ): Response {
        return $this->connector->send(
            new Endpoints\GetPhoneCallsRequest(
                params: $params,
                perPage: $perPage,
                page: $page,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetPhoneCallRequest($id)
        );
    }

    public function store(PhoneCall $phoneCall): Response
    {
        return $this->connector->send(
            new Endpoints\CreatePhoneCallRequest($phoneCall)
        );
    }

    public function update(PhoneCall $phoneCall): Response
    {
        return $this->connector->send(
            new Endpoints\UpdatePhoneCallRequest($phoneCall)
        );
    }

    public function upsert(PhoneCall $phoneCall): Response
    {
        return $phoneCall->id
            ? $this->update($phoneCall)
            : $this->store($phoneCall);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeletePhoneCallRequest($id)
        );
    }
}