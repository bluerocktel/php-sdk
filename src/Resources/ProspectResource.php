<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Contracts\Response;
use BlueRockTEL\SDK\Endpoints\Prospects as Endpoints;

class ProspectResource extends Resource
{
    public function index(
        array $query = [],
        int $perPage = 20,
        int $page = 1,
    ): Response {
        return $this->connector->send(
            new Endpoints\GetProspectsRequest(
                params: $query,
                perPage: $perPage,
                page: $page,
            )
        );
    }

    public function show($id): Response
    {
        return $this->connector->send(
            new Endpoints\GetProspectRequest($id)
        );
    }
}