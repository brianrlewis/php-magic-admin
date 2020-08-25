<?php

namespace AdminSDK\Utils;

class Issuer
{
    public static function parsePublicAddressFromIssuer(string $issuer): string
    {
        $a = explode(':', $issuer);
        return isset($a[2]) ? strtolower($a[2]) : '';
    }

    public static function generateIssuerFromPublicAddress(string $publicAddress, string $method = 'ethr'): string
    {
        return "did:$method:$publicAddress";
    }
}
