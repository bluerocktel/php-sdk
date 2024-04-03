<?php

namespace BlueRockTEL\SDK\Endpoints\PhoneCalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;

class DeletePhoneCallRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/v1/phone-calls/' . $this->id;
    }

    public function __construct(
        protected int $id,
    ) {
        //
    }
}