<?php

namespace BrianRLewis\MagicAdmin\Tests\Modules;

use BrianRLewis\MagicAdmin\Utils\Eth;
use BrianRLewis\MagicAdmin\Utils\Issuer;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testGenerateIssuerFromPublicAddress()
    {
        $result = Issuer::generateIssuerFromPublicAddress('0x1234');
        $this->assertSame($result, 'did:ethr:0x1234');

        $result = Issuer::generateIssuerFromPublicAddress('0x1234', 'test');
        $this->assertSame($result, 'did:test:0x1234');
    }

    public function testParsePublicAddressFromIssuer()
    {
        $result = Issuer::parsePublicAddressFromIssuer('did:ethr:0x1234');
        $this->assertSame($result, '0x1234');

        $result = Issuer::parsePublicAddressFromIssuer('did:ethr');
        $this->assertSame($result, '');
    }
}
