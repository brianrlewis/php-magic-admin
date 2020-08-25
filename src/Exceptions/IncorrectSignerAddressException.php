<?php

namespace AdminSDK\Exceptions;

class IncorrectSignerAddressException extends MagicAdminSDKException
{
    public function __construct()
    {
        parent::__construct('Incorrect signer address for DID Token. Request failed authentication.');
    }
}
