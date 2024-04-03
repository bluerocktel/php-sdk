<?php

namespace BlueRockTEL\SDK\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\Contact;

class CreateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/contacts';
    }

    public function __construct(
        protected Contact $contact,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            'contactable_id' => $this->contact->contactable_id,
            'contactable_type' => $this->contact->contactable_type,
            ...$this->params,
        ];
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->contact->toArray(),
            ['id', 'user_id', 'contactable_id', 'contactable_type', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Contact::fromResponse($response);
    }
}