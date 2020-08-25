<?php

namespace AdminSDK\Modules;

use AdminSDK\Exceptions\ExpectedBearerStringException;
use AdminSDK\Modules\Core\BaseModule;

class Utils extends BaseModule
{
    /**
     * Parse a raw DID Token from the given Authorization header.
     */
    public function parseAuthorizationHeader(string $header): string
    {
        if (substr($header, 0, 7) !== 'bearer ') {
            throw new ExpectedBearerStringException;
        }

        return substr($header, 7);
    }
}
