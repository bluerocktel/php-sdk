<?php

namespace BlueRockTEL\SDK\Endpoints;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AuthRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/login';
    }

    public function __construct(
        #[\SensitiveParameter]
        protected string $email,
        #[\SensitiveParameter]
        protected string $password,
    ) {
        //
    }

    protected function defaultQuery(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}