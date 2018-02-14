<?php

declare(strict_types=1);

/**
 * Copyright (c) 2013-2018 OpenCFP.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Test\Unit\Infrastructure\Auth;

use Localheinz\Test\Util\Helper;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use OpenCFP\Domain\Services\RequestValidator;
use OpenCFP\Infrastructure\Auth\CsrfValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class CsrfValidatorTest extends \PHPUnit\Framework\TestCase
{
    use Helper;
    use MockeryPHPUnitIntegration;

    public function testIsFinal()
    {
        $this->assertClassIsFinal(CsrfValidator::class);
    }

    public function testIsInstanceOfRequestValidator()
    {
        $this->assertClassImplementsInterface(RequestValidator::class, CsrfValidator::class);
    }

    public function testReturnsTrueWhenTokenMangerReturnsTrue()
    {
        $manager = Mockery::mock(CsrfTokenManagerInterface::class);
        $manager->shouldReceive('isTokenValid')->andReturn(true);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('get')->once()->with('token_id');
        $request->shouldReceive('get')->once()->with('token');

        $csrf = new CsrfValidator($manager);
        $this->assertTrue($csrf->isValid($request));
    }

    public function testReturnsFalseWhenTokenManagersReturnsFalse()
    {
        $manager = Mockery::mock(CsrfTokenManagerInterface::class);
        $manager->shouldReceive('isTokenValid')->andReturn(false);
        $request = Mockery::mock(Request::class);

        $request->shouldReceive('get')->once()->with('token_id');
        $request->shouldReceive('get')->once()->with('token');

        $csrf = new CsrfValidator($manager);
        $this->assertFalse($csrf->isValid($request));
    }
}
