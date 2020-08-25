<?php

namespace AdminSDK\Modules;

use AdminSDK\Exceptions\ApiKeyMissingException;
use AdminSDK\Modules\Core\BaseModule;
use AdminSDK\Support\Http;
use AdminSDK\Support\Util;

class Users extends BaseModule
{
    public function logoutByIssuer(string $issuer): void
    {
        if (! $this->sdk->secretApiKey) {
            throw new ApiKeyMissingException;
        }

        Http::post(
            $this->sdk->apiBaseUrl.'/v2/admin/auth/user/logout',
            $this->sdk->secretApiKey,
            ['issuer' => $issuer]
        );
    }

    public function logoutByPublicAddress(string $publicAddress): void
    {
        $issuer = Util::generateIssuerFromPublicAddress($publicAddress);
        $this->logoutByIssuer($issuer);
    }

    public function logoutByToken(string $DIDToken): void
    {
        $issuer = $this->sdk->token->getIssuer($DIDToken);
        $this->logoutByIssuer($issuer);
    }

    public function getMetadataByIssuer(string $issuer)
    {
        if (! $this->sdk->secretApiKey) {
            throw new ApiKeyMissingException;
        }

        $data = Http::get(
            $this->sdk->apiBaseUrl.'/v1/admin/auth/user/get',
            $this->sdk->secretApiKey,
            ['issuer' => $issuer]
        );

        return [
            'issuer' => $data['issuer'] ?? null,
            'publicAddress' => $data['public_address'] ?? null,
            'email' => $data['email'] ?? null,
        ];
    }

    public function getMetadataByToken(string $DIDToken): array
    {
        $issuer = $this->sdk->token->getIssuer($DIDToken);
        return $this->getMetadataByIssuer($issuer);
    }

    public function getMetadataByPublicAddress(string $publicAddress): array
    {
        $issuer = Util::generateIssuerFromPublicAddress($publicAddress);
        return $this->getMetadataByIssuer($issuer);
    }
}
