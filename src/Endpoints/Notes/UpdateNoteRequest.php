<?php

namespace BlueRockTEL\SDK\Endpoints\Notes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\Note;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class UpdateNoteRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v1/notes/' . $this->note->id;
    }

    public function __construct(
        protected Note $note,
    ) {
        if (!$this->note->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->note->toArray(filter: true),
            ['id', 'user_id', 'noteable_id', 'noteable_type', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Note::fromResponse($response);
    }
}