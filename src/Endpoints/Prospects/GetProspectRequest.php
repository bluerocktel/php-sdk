<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use BlueRockTEL\SDK\Entities\Prospect;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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

    public function createDtoFromResponse(Response $response): mixed
    {
        return Prospect::fromResponse($response);
    }
}