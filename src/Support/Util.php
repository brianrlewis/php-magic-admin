<?php

namespace AdminSDK\Support;

use Elliptic\EC;
use kornrunner\Keccak;

class Util
{
    public static function ecRecover(string $message, string $signature)
    {
        $msglen = strlen($message);
        $hash = Keccak::hash("\x19Ethereum Signed Message:\n{$msglen}{$message}", 256);
        $sign = ['r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64), ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;
        if ($recid != ($recid & 1)) {
            return false;
        }

        $ec = new EC('secp256k1');
        $pubkey = $ec->recoverPubKey($hash, $sign, $recid);

        return static::pubKeyToAddress($pubkey);
    }

    public static function pubKeyToAddress($pubkey)
    {
        return '0x'.substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);
    }

    public static function parsePublicAddressFromIssuer(string $issuer): string
    {
        $a = explode(':', $issuer);
        if (isset($a[2])) {
            return strtolower($a[2]);
        } else {
            return '';
        }
    }

    public static function generateIssuerFromPublicAddress(string $publicAddress, string $method = 'ethr'): string
    {
        return "did:$method:$publicAddress";
    }
}
