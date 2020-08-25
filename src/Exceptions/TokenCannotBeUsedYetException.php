<?php

namespace BrianRLewis\MagicAdmin\Exceptions;

class TokenCannotBeUsedYetException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('Given DID Token cannot be used at this time. Please check the `nbf` field and regenerate a new token with a suitable value.');
    }
}
