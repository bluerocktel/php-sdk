<?php

namespace BlueRockTEL\SDK;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\RateLimitPlugin\Limit;
use Saloon\Http\Auth\TokenAuthenticator;
use BlueRockTEL\SDK\Endpoints\AuthRequest;
use Saloon\PaginationPlugin\PagedPaginator;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use BlueRockTEL\SDK\Exceptions\AuthenticationException;

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
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        $this->authenticatePendingRequest($pendingRequest);
    }

    protected function setAccessToken(): void
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
    }

    protected function authenticatePendingRequest(PendingRequest $pendingRequest): void
    {
        if (get_class($pendingRequest->getRequest()) === AuthRequest::class) {
            return;
        }

        if ($pendingRequest->hasMockClient()) {
            return;
        }

        if (!isset($this->apiToken)) {
            $this->setAccessToken();
        }

        $pendingRequest->authenticate(new TokenAuthenticator($this->apiToken));
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
