<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Contracts\Response;
use BlueRockTEL\SDK\Endpoints\GetVersionRequest;

class HelperResource extends Resource
{
    public function version(): Response
    {
        return $this->connector->send(
            new GetVersionRequest()
        );
    }
}