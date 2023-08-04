<?php

namespace BlueRockTEL\SDK\Resources;

use BlueRockTEL\SDK\BlueRockTELConnector;

class Resource
{
    public function __construct(
        protected BlueRockTELConnector $connector
    ) {
        //
    }
}