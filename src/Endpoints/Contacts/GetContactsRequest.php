<?php

namespace BlueRockTEL\SDK\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\Contact;
use BlueRockTEL\SDK\EntityCollection;

class GetContactsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/contacts';
    }

    public function __construct(
        protected string $contactableType,
        protected int $contactableId,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'contactable_type' => $this->contactableType,
            'contactable_id' => $this->contactableId,
        ], $this->params);
    }

    public function createDtoFromResponse(Response $response): EntityCollection
    {
        return EntityCollection::fromResponse($response, Contact::class);
    }
}