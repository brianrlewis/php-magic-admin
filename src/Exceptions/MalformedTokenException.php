<?php

namespace AdminSDK\Exceptions;

class MalformedTokenException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('The DID token is malformed or failed to parse.');
    }
}
