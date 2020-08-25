<?php

namespace AdminSDK\Modules;

use AdminSDK\Exceptions\FailedRecoveringProofError;
use AdminSDK\Exceptions\IncorrectSignerAddressException;
use AdminSDK\Exceptions\MalformedTokenException;
use AdminSDK\Exceptions\TokenCannotBeUsedYetException;
use AdminSDK\Exceptions\TokenExpiredException;
use AdminSDK\Modules\Core\BaseModule;
use AdminSDK\Types\ParsedDIDToken;
use AdminSDK\Utils\DidT;
use AdminSDK\Utils\Eth;
use AdminSDK\Utils\Issuer;
use Throwable;

class Token extends BaseModule
{
    public function validate(string $DIDToken, string $attachment = 'none')
    {
        try {
            $tokenParseResult = DidT::parseDIDToken($DIDToken);
            [$proof, $claim] = $tokenParseResult['raw'];
            $parsedClaim = $tokenParseResult['withParsedClaim'][1];
            $claimedIssuer = Issuer::parsePublicAddressFromIssuer($parsedClaim->iss);
        } catch (Throwable $e) {
            ilog($e);
            throw new MalformedTokenException;
        }

        try {
            // Recover the token signer
            $tokenSigner = strtolower(Eth::ecRecover($claim, $proof));

            // Recover the attachment signer
            $attachmentSigner = strtolower(Eth::ecRecover($attachment, $parsedClaim->add));
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
        if ($parsedClaim->nbf - $nbfLeeway > $timeSecs) {
            throw new TokenCannotBeUsedYetException;
        }
    }

    public function decode(string $DIDToken): ParsedDIDToken
    {
        $parsedToken = DidT::parseDIDToken($DIDToken);
        return $parsedToken['withParsedClaim'];
    }

    public function getPublicAddress(string $DIDToken): string
    {
        $claim = $this->decode($DIDToken)[1];
        $claimedIssuer = explode(':', $claim->iss)[2];
        return $claimedIssuer;
    }

    public function getIssuer(string $DIDToken): string
    {
        return $this->decode($DIDToken)[1]->iss;
    }
}
