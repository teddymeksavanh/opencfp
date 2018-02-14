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

namespace OpenCFP\Test\Unit\Domain\Speaker;

use Localheinz\Test\Util\Helper;
use OpenCFP\Domain\Speaker\NotAllowedException;
use PHPUnit\Framework;

final class NotAllowedExceptionTest extends Framework\TestCase
{
    use Helper;

    public function testIsException()
    {
        $this->assertClassExtends(\Exception::class, NotAllowedException::class);
    }

    public function testNotAllowedToViewReturnsException()
    {
        $property = 'foo';

        $exception = NotAllowedException::notAllowedToView($property);

        $this->assertInstanceOf(NotAllowedException::class, $exception);
        $this->assertSame(0, $exception->getCode());

        $message = \sprintf(
            'Not allowed to view %s. Hidden property',
            $property
        );

        $this->assertSame($message, $exception->getMessage());
    }
}
