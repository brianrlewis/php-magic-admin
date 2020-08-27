<?php

namespace BrianRLewis\MagicAdmin\Tests\Modules;

use BrianRLewis\MagicAdmin\Exceptions\ExpectedBearerStringException;
use BrianRLewis\MagicAdmin\Tests\Support\Constants;
use BrianRLewis\MagicAdmin\Tests\Support\Factories;
use PHPUnit\Framework\TestCase;

class UtilsModuleTest extends TestCase
{
    protected $magic;

    protected function setUp(): void
    {
        $this->magic = Factories::createMagicAdminSDK();
    }

    public function testParseAuthorizationHeader()
    {
        $result = $this->magic->utils->parseAuthorizationHeader('Bearer '.Constants::VALID_DIDT);
        $this->assertSame($result, Constants::VALID_DIDT);
    }

    public function testExpectedBearerStringException()
    {
        $this->expectException(ExpectedBearerStringException::class);
        $this->magic->utils->parseAuthorizationHeader('Incorrect '.Constants::VALID_DIDT);
    }
}
