<?php

namespace AdminSDK;

use AdminSDK\Modules\Token;
use AdminSDK\Modules\Users;
use AdminSDK\Modules\Utils;

class Magic
{
    public $apiBaseUrl;
    public $secretApiKey;
    public $users;
    public $token;
    public $utils;

    public function __construct(string $secretApiKey, array $options = [])
    {
        $endpoint = $options['endpoint'] ?? 'https://api.magic.link';

        $this->apiBaseUrl = preg_replace('/\/+$/', '', $endpoint);
        $this->secretApiKey = $secretApiKey;
        $this->options = $options;
        $this->users = new Users($this);
        $this->token = new Token($this);
        $this->utils = new Utils($this);
    }
}
