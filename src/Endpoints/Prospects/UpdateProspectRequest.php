<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Prospect;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class UpdateProspectRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v1/prospects/' . $this->prospect->id;
    }

    public function __construct(
        protected Prospect $prospect,
    ) {
        if (!$this->prospect->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->prospect->toArray(filter: true),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Prospect::fromResponse($response);
    }
}