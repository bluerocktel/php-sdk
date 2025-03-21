<?php

namespace BlueRockTEL\SDK;

use Saloon\Http\Request;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Limit;
use BlueRockTEL\SDK\Endpoints\AuthRequest;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use BlueRockTEL\SDK\Exceptions\AuthenticationException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\PaginationPlugin\Contracts\HasPagination;

class BlueRockTELConnector extends Connector implements HasPagination
{
    use HasRateLimits;

    protected string $apiToken;
    protected array $apiUser;

    public function __construct(
        protected string $apiUrl,
        #[\SensitiveParameter]
        protected string $email,
        #[\SensitiveParameter]
        protected string $password,
    ) {
        $this->setAccessToken();
    }

    protected function setAccessToken()
    {
        $response = $this->send(
            new AuthRequest($this->email, $this->password)
        );

        if ($response->failed()) {
            throw new AuthenticationException(
                'Failed to authenticate with BlueRockTEL API. Please check your credentials.'
            );
        }

        $body = $response->json();

        $this->apiUser = $body['user'];
        $this->apiToken = $body['token'];

        $this->authenticate(new TokenAuthenticator($this->apiToken));
    }

    public function resolveBaseUrl(): string
    {
        return $this->apiUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultQuery(): array
    {
        return [];
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 60,
        ];
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 2000, threshold: 0.9)->everyMinute()->sleep(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new MemoryStore;
    }

    public function paginate(Request $request): PagedPaginator
    {
        return new class(connector: $this, request: $request) extends PagedPaginator {
            protected ?int $perPageLimit = 20;

            protected function isLastPage(Response $response): bool
            {
                return $response->json('last_page')
                    && $response->json('last_page') === $response->json('current_page');
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $request->createDtoFromResponse($response->json('data'))->all();
            }
        };
    }

    public function helper(): Resources\HelperResource
    {
        return new Resources\HelperResource($this);
    }

    public function user(): Resources\UserResource
    {
        return new Resources\UserResource($this);
    }

    public function customer(): Resources\CustomerResource
    {
        return new Resources\CustomerResource($this);
    }

    public function prospect(): Resources\ProspectResource
    {
        return new Resources\ProspectResource($this);
    }

    public function contact(): Resources\ContactResource
    {
        return new Resources\ContactResource($this);
    }

    public function note(): Resources\NoteResource
    {
        return new Resources\NoteResource($this);
    }

    public function phoneCall(): Resources\PhoneCallResource
    {
        return new Resources\PhoneCallResource($this);
    }
}
