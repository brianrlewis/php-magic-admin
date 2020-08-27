<?php

namespace BrianRLewis\MagicAdmin\Utils;

use BrianRLewis\MagicAdmin\Exceptions\MalformedTokenException;
use BrianRLewis\MagicAdmin\Types\Claim;
use BrianRLewis\MagicAdmin\Types\ParsedDIDToken;
use Throwable;

class DidT
{
    public static function parseDIDToken(string $DIDToken): array
    {
        try {
            [$proof, $claim] = json_decode(base64_decode($DIDToken));
            $parsedClaim = new Claim(json_decode($claim, true));
            return [
                'raw' =>  [$proof, $claim],
                'withParsedClaim' => new ParsedDIDToken([$proof, $parsedClaim]),
            ];
        } catch (Throwable $e) {
            throw new MalformedTokenException;
        }
    }
}
