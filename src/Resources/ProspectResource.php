<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Contracts\Response;
use BlueRockTEL\SDK\Entities\Prospect;
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

    public function store(Prospect $prospect): Response
    {
        return $this->connector->send(
            new Endpoints\CreateProspectRequest($prospect)
        );
    }

    public function update(Prospect $prospect): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateProspectRequest($prospect)
        );
    }

    public function save(Prospect $prospect): Response
    {
        return $prospect->id
            ? $this->update($prospect)
            : $this->store($prospect);
    }

    public function delete(Prospect $prospect): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteProspectRequest($prospect)
        );
    }
}