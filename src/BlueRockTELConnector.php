<?php

namespace BlueRockTEL\SDK;

use Saloon\Http\Request;
use Saloon\Http\Connector;
use BlueRockTEL\SDK\Endpoints\AuthRequest;
use Saloon\Http\Paginators\PagedPaginator;
use BlueRockTEL\SDK\Exceptions\AuthenticationException;

class BlueRockTELConnector extends Connector
{
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

        $body = $response->json();

        if ($response->failed()) {
            throw new AuthenticationException(
                'Failed to authenticate with BlueRockTEL API. Please check your credentials.'
            );
        }

        $this->apiUser = $body['user'];
        $this->apiToken = $body['token'];

        $this->withTokenAuth($this->apiToken); 
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

    public function paginate(Request $request, int $perPage = 20, int $page = 1): PagedPaginator
    {
        $paginator = new PagedPaginator($this, $request, $perPage, $page);

        $paginator->setLimitKeyName('last_page');
        $paginator->setTotalKeyName('total');
        $paginator->setPageKeyName('page');
        $paginator->setNextPageKeyName('next_page_url');

        return $paginator;
    } 

    public function helper(): Resources\HelperResource
    {
        return new Resources\HelperResource($this);
    }

    public function prospect(): Resources\ProspectResource
    {
        return new Resources\ProspectResource($this);
    }

    public function note(): Resources\NoteResource
    {
        return new Resources\NoteResource($this);
    }
}