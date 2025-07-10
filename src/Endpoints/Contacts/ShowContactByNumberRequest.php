<?php

namespace BlueRockTEL\SDK\Endpoints\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\Contact;
use BlueRockTEL\SDK\EntityCollection;

class ShowContactByNumberRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/contacts/numbers';
    }

    public function __construct(
        protected string $phoneNumber,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            'phoneNumber' => $this->phoneNumber,
            ...$this->params,
        ];
    }

    public function createDtoFromResponse(Response $response): Contact
    {
        return Contact::fromResponse($response, 'data');
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        $textualResponse = $response->json('response');

        return $textualResponse && str_contains($textualResponse, 'not found');
    }
}
