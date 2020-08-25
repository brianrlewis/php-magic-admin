<?php

namespace BrianRLewis\MagicAdmin\Types;

use BrianRLewis\MagicAdmin\Types\Core\BaseType;

class Claim extends BaseType
{
    public $iat; // Issued At Timestamp
    public $ext; // Expiration Timestamp
    public $iss; // Issuer of DID Token
    public $sub; // Subject
    public $aud; // Audience
    public $nbf; // Not Before Timestamp
    public $tid; // DID Token ID
    public $add; // Encrypted signature of arbitrary data

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->iat = $data['iat'];
        $this->ext = $data['ext'];
        $this->iss = $data['iss'];
        $this->sub = $data['sub'];
        $this->aud = $data['aud'];
        $this->nbf = $data['nbf'];
        $this->tid = $data['tid'];
        $this->add = $data['add'];
    }
}
