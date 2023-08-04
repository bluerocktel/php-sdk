<?php

namespace BlueRockTEL\SDK\Endpoints;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetVersionRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/version';
    }
}