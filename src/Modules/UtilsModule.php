<?php

namespace BrianRLewis\MagicAdmin\Modules;

use BrianRLewis\MagicAdmin\Exceptions\ExpectedBearerStringException;
use BrianRLewis\MagicAdmin\Modules\Core\BaseModule;

class UtilsModule extends BaseModule
{
    /**
     * Parse a raw DID Token from the given Authorization header.
     */
    public function parseAuthorizationHeader(string $header): string
    {
        if (substr(strtolower($header), 0, 7) !== 'bearer ') {
            throw new ExpectedBearerStringException;
        }

        return substr($header, 7);
    }
}
