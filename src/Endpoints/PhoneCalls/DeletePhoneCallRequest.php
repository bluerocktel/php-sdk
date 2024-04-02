<?php

namespace BlueRockTEL\SDK\Endpoints\PhoneCalls;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use BlueRockTEL\SDK\Entities\PhoneCall;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use BlueRockTEL\SDK\Exceptions\EntityIdMissingException;

class DeletePhoneCallRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

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
}