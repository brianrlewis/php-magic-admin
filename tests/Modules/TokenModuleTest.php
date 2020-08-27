<?php

namespace BrianRLewis\MagicAdmin\Tests\Modules;

use BrianRLewis\MagicAdmin\Exceptions\FailedRecoveringProofException;
use BrianRLewis\MagicAdmin\Exceptions\IncorrectSignerAddressException;
use BrianRLewis\MagicAdmin\Exceptions\MalformedTokenException;
use BrianRLewis\MagicAdmin\Exceptions\TokenCannotBeUsedYetException;
use BrianRLewis\MagicAdmin\Exceptions\TokenExpiredException;
use BrianRLewis\MagicAdmin\Tests\Support\Constants;
use BrianRLewis\MagicAdmin\Tests\Support\Factories;
use PHPUnit\Framework\TestCase;

class TokenModuleTest extends TestCase
{
    protected $magic;

    protected function setUp(): void
    {
        $this->magic = Factories::createMagicAdminSDK();
    }

    public function testGetIssuer()
    {
        $result = $this->magic->token->getIssuer(Constants::VALID_DIDT);
        $this->assertSame($result, Constants::VALID_DIDT_PARSED_CLAIMS['iss']);
    }

    public function testGetPublicAddress()
    {
        $result = $this->magic->token->getPublicAddress(Constants::VALID_DIDT);
        $this->assertSame($result, explode(':', Constants::VALID_DIDT_PARSED_CLAIMS['iss'])[2]);
    }

    public function testDecode()
    {
        $result = $this->magic->token->decode(Constants::VALID_DIDT);
        $this->assertSame($result->toArray(), Constants::VALID_DIDT_DECODED);

        $this->expectException(MalformedTokenException::class);
        $this->magic->token->decode(Constants::INVALID_DIDT_MALFORMED_CLAIM);
    }

    /**
     *  @doesNotPerformAssertions
     */
    public function testValidate()
    {
        $this->magic->token->validate(Constants::VALID_DIDT);
    }

    public function testIncorrectSignerAddressException()
    {
        $this->expectException(IncorrectSignerAddressException::class);
        $this->magic->token->validate(Constants::INVALID_SIGNER_DIDT);
    }

    public function testTokenExpiredException()
    {
        $this->expectException(TokenExpiredException::class);
        $this->magic->token->validate(Constants::EXPIRED_DIDT);
    }

    public function testTokenCannotBeUsedYetException()
    {
        $this->expectException(TokenCannotBeUsedYetException::class);
        $this->magic->token->validate(Constants::VALID_FUTURE_MARKED_DIDT);
    }

    public function testFailedRecoveringProofException()
    {
        $this->expectException(FailedRecoveringProofException::class);
        $this->magic->token->validate(Constants::getTokenThatShouldFailRecoveryProof());
    }

    public function testMalformedTokenException()
    {
        //  fwrite(STDERR, print_r(Constants::INVALID_DIDT_MALFORMED_CLAIM_DECODED, true));
        $this->expectException(MalformedTokenException::class);
        $this->magic->token->validate(Constants::INVALID_DIDT_MALFORMED_CLAIM);
    }
}
