<?php

namespace BlueRockTEL\SDK\Endpoints\Notes;

use BlueRockTEL\SDK\Entities\Note;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetNoteRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/notes/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Note::fromResponse($response);
    }
}