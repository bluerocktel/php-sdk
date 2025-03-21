<?php

namespace BlueRockTEL\SDK\Endpoints\Prospects;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\SDK\EntityCollection;
use BlueRockTEL\SDK\Entities\Prospect;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetProspectsRequest extends Request implements Paginatable
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/prospects';
    }

    public function __construct(
        protected array $params = [],
        protected int $perPage = 20,
        protected int $page = 1,
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            ...$this->params,
        ];
    }

    public function createDtoFromResponse(Response | array $response): EntityCollection
    {
        return is_array($response)
            ? EntityCollection::fromArray($response, Prospect::class)
            : EntityCollection::fromResponse($response, Prospect::class, 'data');
    }
}
