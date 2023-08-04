<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateProspectRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/servers';
    }
}