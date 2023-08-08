<?php

namespace BlueRockTEL\SDK\Endpoints\Notes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use BlueRockTEL\SDK\Entities\Note;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class DeleteNoteRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

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
}