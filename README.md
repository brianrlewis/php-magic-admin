# Magic Admin SDK

This package is an unofficial implementation of the Magic Admin SDK specification.

The API matches the official Node version (https://docs.magic.link/admin-sdk/node).

This package has not undergone rigorous testing so use with caution.

## Basic Usage

```
use BrianRLewis\MagicAdmin\Magic;

$secretApiKey = 'sk_test_123456789';
$magic = new Magic($secretApiKey);

// Validate a DIDToken

$DIDToken = '...';
$magic->token->validate($DIDToken);

// Retrieve a user's metadata

$DIDToken = '...';
$metadata = $magic->users->getMetadataByToken($DIDToken);

echo $metadata->email;
echo $metadata->publicAddress;
echo $metadata->issuer;

//Parse a raw DID Token from the given Authorization header.

$header = 'bearer <DIDToken>';
$DIDToken = $magic->utils->parseAuthorizationHeader($header);

```
