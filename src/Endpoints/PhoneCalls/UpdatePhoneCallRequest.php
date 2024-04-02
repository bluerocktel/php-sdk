<?php

namespace BlueRockTEL\SDK\Endpoints\PhoneCalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use BlueRockTEL\SDK\Entities\PhoneCall;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class UpdatePhoneCallRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return '/v1/phone-calls/' . $this->phoneCall->id;
    }

    public function __construct(
        protected PhoneCall $phoneCall,
    ) {
        if (!$this->phoneCall->id) {
            throw new EntityIdMissingException('Entity must have an ID to be updated.');
        }
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->phoneCall->toArray(filter: false),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return PhoneCall::fromResponse($response);
    }
}