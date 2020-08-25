<?php

namespace BrianRLewis\MagicAdmin\Modules;

use BrianRLewis\MagicAdmin\Exceptions\FailedRecoveringProofError;
use BrianRLewis\MagicAdmin\Exceptions\IncorrectSignerAddressException;
use BrianRLewis\MagicAdmin\Exceptions\MalformedTokenException;
use BrianRLewis\MagicAdmin\Exceptions\TokenCannotBeUsedYetException;
use BrianRLewis\MagicAdmin\Exceptions\TokenExpiredException;
use BrianRLewis\MagicAdmin\Modules\Core\BaseModule;
use BrianRLewis\MagicAdmin\Types\ParsedDIDToken;
use BrianRLewis\MagicAdmin\Utils\DidT;
use BrianRLewis\MagicAdmin\Utils\Eth;
use BrianRLewis\MagicAdmin\Utils\Issuer;
use Throwable;

class TokenModule extends BaseModule
{
    public function validate(string $DIDToken, string $attachment = 'none')
    {
        try {
            $tokenParseResult = DidT::parseDIDToken($DIDToken);
            [$proof, $claim] = $tokenParseResult['raw'];
            $parsedClaim = $tokenParseResult['withParsedClaim'][1];
            $claimedIssuer = Issuer::parsePublicAddressFromIssuer($parsedClaim->iss);
        } catch (Throwable $e) {
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
        if ($parsedClaim->ext < $timeSecs) {
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
