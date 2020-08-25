<?php

namespace BrianRLewis\MagicAdmin\Exceptions;

class TokenExpiredException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('DID Token has expired. Request failed authentication.');
    }
}
