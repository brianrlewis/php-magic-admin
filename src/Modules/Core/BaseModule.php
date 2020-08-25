<?php

namespace BrianRLewis\MagicAdmin\Modules\Core;

use BrianRLewis\MagicAdmin\Magic;

class BaseModule
{
    protected $sdk;

    public function __construct(Magic $sdk)
    {
        $this->sdk = $sdk;
    }
}
