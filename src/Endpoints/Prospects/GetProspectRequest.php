<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetProspectRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/prospects/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}