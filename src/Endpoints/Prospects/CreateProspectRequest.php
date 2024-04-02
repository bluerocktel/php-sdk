<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Prospect;

class CreateProspectRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/prospects';
    }

    public function __construct(
        protected Prospect $prospect,
    ) {
        //
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->prospect->toArray(),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Prospect::fromResponse($response);
    }
}