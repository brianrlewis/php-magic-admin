<?php

namespace AdminSDK\Exceptions;

use RuntimeException;

class MagicAdminSDKException extends RuntimeException
{
    public function __construct(string $message = '')
    {
        parent::__construct("Magic Admin SDK Error: $message");
    }
}
