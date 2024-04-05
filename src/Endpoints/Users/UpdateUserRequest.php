<?php

namespace BlueRockTEL\SDK\Endpoints\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\User;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class UpdateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v1/users/' . $this->user->id;
    }

    public function __construct(
        protected User $user,
    ) {
        if (!$this->user->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->user->toArray(filter: true),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return User::fromResponse($response);
    }
}