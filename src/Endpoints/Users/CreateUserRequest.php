<?php

namespace BlueRockTEL\SDK\Endpoints\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\User;

class CreateUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/users';
    }

    public function __construct(
        protected User $user,
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

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->user->toArray(),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return User::fromResponse($response);
    }
}