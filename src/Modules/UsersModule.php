<?php

namespace BrianRLewis\MagicAdmin\Modules;

use BrianRLewis\MagicAdmin\Exceptions\ApiKeyMissingException;
use BrianRLewis\MagicAdmin\Modules\Core\BaseModule;
use BrianRLewis\MagicAdmin\Types\MagicUserMetadata;
use BrianRLewis\MagicAdmin\Utils\Issuer;
use BrianRLewis\MagicAdmin\Utils\Rest;

class UsersModule extends BaseModule
{
    public function logoutByIssuer(string $issuer): void
    {
        if (! $this->sdk->secretApiKey) {
            throw new ApiKeyMissingException;
        }

        Rest::post(
            $this->sdk->apiBaseUrl.'/v2/admin/auth/user/logout',
            $this->sdk->secretApiKey,
            ['issuer' => $issuer]
        );
    }

    public function logoutByPublicAddress(string $publicAddress): void
    {
        $issuer = Issuer::generateIssuerFromPublicAddress($publicAddress);
        $this->logoutByIssuer($issuer);
    }

    public function logoutByToken(string $DIDToken): void
    {
        $issuer = $this->sdk->token->getIssuer($DIDToken);
        $this->logoutByIssuer($issuer);
    }

    public function getMetadataByIssuer(string $issuer): MagicUserMetadata
    {
        if (! $this->sdk->secretApiKey) {
            throw new ApiKeyMissingException;
        }

        $data = Rest::get(
            $this->sdk->apiBaseUrl.'/v1/admin/auth/user/get',
            $this->sdk->secretApiKey,
            ['issuer' => $issuer]
        );

        return new MagicUserMetadata($data);
    }

    public function getMetadataByToken(string $DIDToken): MagicUserMetadata
    {
        $issuer = $this->sdk->token->getIssuer($DIDToken);
        return $this->getMetadataByIssuer($issuer);
    }

    public function getMetadataByPublicAddress(string $publicAddress): MagicUserMetadata
    {
        $issuer = Issuer::generateIssuerFromPublicAddress($publicAddress);
        return $this->getMetadataByIssuer($issuer);
    }
}
