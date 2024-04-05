<?php

namespace BlueRockTEL\SDK\Endpoints\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\User;
use BlueRockTEL\SDK\EntityCollection;

class GetUsersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/users';
    }

    public function __construct(
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            ...$this->params,
        ];
    }

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, User::class);
    }
}