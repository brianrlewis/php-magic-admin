<?php

namespace AdminSDK\Modules;

use AdminSDK\Exceptions\FailedRecoveringProofError;
use AdminSDK\Exceptions\IncorrectSignerAddressException;
use AdminSDK\Exceptions\MalformedTokenException;
use AdminSDK\Exceptions\TokenCannotBeUsedYetException;
use AdminSDK\Exceptions\TokenExpiredException;
use AdminSDK\Modules\Core\BaseModule;
use AdminSDK\Support\Util;
use Throwable;

class Token extends BaseModule
{
    public function validate(string $DIDToken, string $attachment = 'none')
    {
        try {
            $tokenParseResult = $this->parseDIDToken($DIDToken);
            [$proof, $claim] = $tokenParseResult['raw'];
            $parsedClaim = $tokenParseResult['withParsedClaim'][1];
            $claimedIssuer = Util::parsePublicAddressFromIssuer($parsedClaim['iss']);
        } catch (Throwable $e) {
            throw new MalformedTokenException;
        }

        try {
            // Recover the token signer
            $tokenSigner = strtolower(Util::ecRecover($claim, $proof));

            // Recover the attachment signer
            $attachmentSigner = strtolower(Util::ecRecover($attachment, $parsedClaim['add']));
        } catch (Throwable $e) {
            throw new FailedRecoveringProofError;
        }

        // Assert the expected signer
        if ($claimedIssuer !== $tokenSigner || $claimedIssuer !== $attachmentSigner) {
            throw new IncorrectSignerAddressException;
        }

        $timeSecs = time();
        $nbfLeeway = 300; // 5 min grace period

        // Assert the token is not expired
        if ($parsedClaim['ext'] < $timeSecs) {
            throw new TokenExpiredException;
        }

        // Assert the token is not used before allowed.
        if ($parsedClaim['nbf'] - $nbfLeeway > $timeSecs) {
            throw new TokenCannotBeUsedYetException;
        }
    }

    public function parseDIDToken(string $DIDToken): array
    {
        [$proof, $claim] = json_decode(base64_decode($DIDToken));
        $parsedClaim = json_decode($claim, true);
        if ($this->isDIDTClaim($parsedClaim)) {
            return [
                'raw' =>  [$proof, $claim],
                'withParsedClaim' => [$proof, $parsedClaim],
            ];
        } else {
            throw new MalformedTokenException;
        }
    }

    public function isDIDTClaim($value): string
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

    public function decode(string $DIDToken): array
    {
        $parsedToken = $this->parseDIDToken($DIDToken);
        return $parsedToken['withParsedClaim'];
    }

    public function getPublicAddress(string $DIDToken): string
    {
        $claim = $this->decode($DIDToken)[1];
        $claimedIssuer = explode(':', $claim['iss'])[2];
        return $claimedIssuer;
    }

    public function getIssuer(string $DIDToken): string
    {
        return $this->decode($DIDToken)[1]['iss'];
    }
}
