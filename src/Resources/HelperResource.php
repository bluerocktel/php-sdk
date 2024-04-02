<?php

namespace BlueRockTEL\SDK\Resources;

use Saloon\Http\Response;
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