<?php

namespace BlueRockTEL\SDK\Endpoints\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class DeleteUserRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v1/users/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}