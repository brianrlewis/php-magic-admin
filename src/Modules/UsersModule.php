<?php

namespace AdminSDK\Modules;

use AdminSDK\Exceptions\ApiKeyMissingException;
use AdminSDK\Modules\Core\BaseModule;
use AdminSDK\Types\MagicUserMetadata;
use AdminSDK\Utils\Issuer;
use AdminSDK\Utils\Rest;

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
