<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\User;
use BlueRockTEL\SDK\Endpoints\Users as Endpoints;

class UserResource extends Resource
{
    public function index(
        array $query = [],
    ): Response {
        return $this->connector->send(
            new Endpoints\GetUsersRequest(
                params: $query,
            )
        );
    }

    public function show(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\GetUserRequest($id)
        );
    }

    public function store(User $user): Response
    {
        return $this->connector->send(
            new Endpoints\CreateUserRequest($user)
        );
    }

    public function update(User $user): Response
    {
        return $this->connector->send(
            new Endpoints\UpdateUserRequest($user)
        );
    }

    public function upsert(User $user): Response
    {
        return $user->id
            ? $this->update($user)
            : $this->store($user);
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(
            new Endpoints\DeleteUserRequest($id)
        );
    }
}