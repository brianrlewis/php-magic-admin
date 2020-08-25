<?php

namespace BrianRLewis\MagicAdmin\Types;

use BrianRLewis\MagicAdmin\Types\Core\BaseType;

class MagicUserMetadata extends BaseType
{
    public $issuer;
    public $publicAddress;
    public $email;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->issuer = $data['issuer'] ?? null;
        $this->publicAddress = $data['public_address'] ?? null;
        $this->email = $data['email'] ?? null;
    }
}
