<?php

namespace AdminSDK;

use AdminSDK\Modules\TokenModule;
use AdminSDK\Modules\UsersModule;
use AdminSDK\Modules\UtilsModule;

class Magic
{
    public $apiBaseUrl;
    public $secretApiKey;

    /**
     * @var UsersModule
     */
    public $users;

    /**
     * @var TokenModule
     */
    public $token;

    /**
     * @var UtilsModule
     */
    public $utils;

    public function __construct(string $secretApiKey, array $options = [])
    {
        $endpoint = $options['endpoint'] ?? 'https://api.magic.link';

        $this->apiBaseUrl = preg_replace('/\/+$/', '', $endpoint);
        $this->secretApiKey = $secretApiKey;
        $this->options = $options;
        $this->users = new UsersModule($this);
        $this->token = new TokenModule($this);
        $this->utils = new UtilsModule($this);
    }
}
