<?php

namespace BlueRockTEL\SDK\Endpoints\Notes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Contracts\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Note;

class CreateNoteRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/notes';
    }

    public function __construct(
        protected Note $note,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'noteable_id' => $this->note->noteable_id,
            'noteable_type' => $this->note->noteable_type,
        ], $this->params);
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->note->toArray(),
            ['id', 'user_id', 'noteable_id', 'noteable_type', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Note::fromResponse($response);
    }
}