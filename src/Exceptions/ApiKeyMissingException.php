<?php

namespace AdminSDK\Exceptions;

class ApiKeyMissingException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('Please provide a secret Fortmatic API key that you acquired from the developer dashboard.');
    }
}
