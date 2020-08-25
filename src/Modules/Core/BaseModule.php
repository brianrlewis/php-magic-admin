<?php

namespace AdminSDK\Modules\Core;

use AdminSDK\Magic;

class BaseModule
{
    protected $sdk;

    public function __construct(Magic $sdk)
    {
        $this->sdk = $sdk;
    }
}
