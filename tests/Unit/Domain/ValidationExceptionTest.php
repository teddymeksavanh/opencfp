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

namespace OpenCFP\Test\Unit\Domain;

use Localheinz\Test\Util\Helper;
use OpenCFP\Domain\ValidationException;
use PHPUnit\Framework;

final class ValidationExceptionTest extends Framework\TestCase
{
    use Helper;

    public function testIsException()
    {
        $this->assertClassExtends(\Exception::class, ValidationException::class);
    }

    public function testWithErrorsReturnsException()
    {
        $errors = $this->faker()->sentences;

        $exception = ValidationException::withErrors($errors);

        $this->assertInstanceOf(ValidationException::class, $exception);
        $this->assertSame('There was an error.', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($errors, $exception->errors());
    }
}
