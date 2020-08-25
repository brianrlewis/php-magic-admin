<?php

namespace AdminSDK\Exceptions;

class ExpectedBearerStringException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('Expected argument to be a string in the `Bearer {token}` format.');
    }
}
