<?php

namespace BrianRLewis\MagicAdmin\Utils;

use BrianRLewis\MagicAdmin\Exceptions\MalformedTokenException;
use BrianRLewis\MagicAdmin\Types\Claim;
use BrianRLewis\MagicAdmin\Types\ParsedDIDToken;

class DidT
{
    public static function parseDIDToken(string $DIDToken): array
    {
        [$proof, $claim] = json_decode(base64_decode($DIDToken));
        $parsedClaim = new Claim(json_decode($claim, true));
        if (static::isDIDTClaim($parsedClaim)) {
            return [
                'raw' =>  [$proof, $claim],
                'withParsedClaim' => new ParsedDIDToken([$proof, $parsedClaim]),
            ];
        } else {
            throw new MalformedTokenException;
        }
    }

    public static function isDIDTClaim(Claim $claim): bool
    {
        return
            is_object($claim) &&
            isset($claim->iat) &&
            isset($claim->ext) &&
            isset($claim->iss) &&
            isset($claim->sub) &&
            isset($claim->aud) &&
            isset($claim->nbf) &&
            isset($claim->tid) &&
            isset($claim->add);
    }
}
