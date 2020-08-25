<?php

namespace AdminSDK\Utils;

use AdminSDK\Exceptions\MalformedTokenException;

class DidT
{
    public static function parseDIDToken(string $DIDToken): array
    {
        [$proof, $claim] = json_decode(base64_decode($DIDToken));
        $parsedClaim = json_decode($claim, true);
        if (static::isDIDTClaim($parsedClaim)) {
            return [
                'raw' =>  [$proof, $claim],
                'withParsedClaim' => [$proof, $parsedClaim],
            ];
        } else {
            throw new MalformedTokenException;
        }
    }

    public static function isDIDTClaim($value): string
    {
        return
            is_array($value) &&
            isset($value['iat']) &&
            isset($value['ext']) &&
            isset($value['iss']) &&
            isset($value['sub']) &&
            isset($value['aud']) &&
            isset($value['nbf']) &&
            isset($value['tid']) &&
            isset($value['add']);
    }
}
