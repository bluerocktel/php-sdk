<?php

namespace BlueRockTEL\SDK\Endpoints\Notes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\Note;
use BlueRockTEL\SDK\EntityCollection;

class GetNotesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/notes';
    }

    public function __construct(
        protected string $noteableType,
        protected int $noteableId,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'noteable_type' => $this->noteableType,
            'noteable_id' => $this->noteableId,
        ], $this->params);
    }

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, Note::class);
    }
}