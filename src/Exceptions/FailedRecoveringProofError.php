<?php

namespace AdminSDK\Exceptions;

class FailedRecoveringProofError extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('Failed to recover proof. Request failed authentication.');
    }
}
