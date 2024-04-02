<?php

namespace BlueRockTEL\SDK\Endpoints\PhoneCalls;

use BlueRockTEL\SDK\Entities\PhoneCall;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPhoneCallRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/phone-calls/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return PhoneCall::fromResponse($response);
    }
}