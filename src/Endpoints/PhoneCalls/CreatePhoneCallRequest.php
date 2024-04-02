<?php

namespace BlueRockTEL\SDK\Endpoints\PhoneCalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Illuminate\Support\Arr;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Entities\PhoneCall;

class CreatePhoneCallRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/notes';
    }

    public function __construct(
        protected PhoneCall $phoneCall,
        protected array $params = [],
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return $this->params;
    }

    protected function defaultBody(): array
    {
        return Arr::except(
            $this->phoneCall->toArray(),
            ['id', 'created_at', 'updated_at']
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return PhoneCall::fromResponse($response);
    }
}