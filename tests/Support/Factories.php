<?php

namespace BrianRLewis\MagicAdmin\Tests\Support;

use BrianRLewis\MagicAdmin\Magic;

class Factories
{
    public static function createMagicAdminSDK($endpoint = Constants::API_FULL_URL)
    {
        return new Magic(Constants::API_KEY, ['endpoint' => $endpoint]);
    }
}
