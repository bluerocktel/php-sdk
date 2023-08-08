<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Prospect;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class DeleteProspectRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v1/prospects/' . $this->prospect->id;
    }

    public function __construct(
        protected Prospect $prospect,
    ) {
        if (!$this->prospect->id) {
            throw new EntityIdMissingException('Entity must have an ID to be deleted.');
        }
    }
}