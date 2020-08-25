# Magic Admin SDK

This package is an unofficial implementation of the Magic Admin SDK specification.

As of August 2020 there is no official server side Admin SDK for PHP, only for Node and Python. Magic is intending to release a PHP implementation in the near future (https://docs.magic.link/admin-sdk/coming-soon).

The API of this package matches (as closely as possible) the official Node version (https://docs.magic.link/admin-sdk/node).

This package has not undergone rigorous testing so use with caution.

## Prerequisites

This is a server side package that is intended for use in conjunction with one of the official client SDKs (https://docs.magic.link/client-sdk/web) provided by Magic.

## Installation

Run this command to install via composer.

```
composer require brianrlewis/magic-admin
```

Obtain your secret api key by creating an account at https://magic.link

## Usage

Create instance.

```
use BrianRLewis\MagicAdmin\Magic;

$secretApiKey = 'sk_XXXX_XXXXXXXXXXXXXXXX';
$options = ['endpoint' => 'https://api.magic.link'] // Optional
$magic = new Magic($secretApiKey, $options);
```

Token Module (https://docs.magic.link/admin-sdk/node#token-module)

```
$magic->token->validate('<DIDToken>); 

$magic->token->getIssuer('<DIDToken>); 

$magic->token->decode('<DIDToken>); 

$magic->token->getPublicAddress('<DIDToken>); 
```

Users Module (https://docs.magic.link/admin-sdk/node#user-module)

```
$magic->users->logoutByIssuer('<issuer>);

$magic->users->logoutByPublicAddress('<publicAddress>);

$magic->users->logoutByToken('<DIDToken>);

$metadata = $magic->users->getMetadataByIssuer('<issuer>);

$metadata = $magic->users->getMetadataByPublicAddress('<publicAddress>);

$metadata = $magic->users->getMetadataByToken('<DIDToken>);

echo $metadata->email;
echo $metadata->publicAddress;
echo $metadata->issuer;
```

Utils Module (https://docs.magic.link/admin-sdk/node#utils-module)

```
$header = 'bearer <DIDToken>';
$DIDToken = $magic->utils->parseAuthorizationHeader($header);

```

For further details look at the official documentation (https://docs.magic.link/admin-sdk/node)