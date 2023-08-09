<?php

namespace BlueRockTEL\SDK\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use BlueRockTEL\SDK\Entities\Contact;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class DeleteContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v1/contacts/' . $this->contact->id;
    }

    public function __construct(
        protected Contact $contact,
    ) {
        if (!$this->contact->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }
}