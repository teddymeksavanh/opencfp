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

namespace OpenCFP\Test\Unit\Http\Action\Page;

use OpenCFP\Http\Action\Page\HomePageAction;
use PHPUnit\Framework\TestCase;

final class HomePageActionTest extends TestCase
{
    public function testItReturnsTheCorrectContentIfNoSubmissionCountNeedsToBeShown()
    {
        $action = new HomePageAction(false);

        $expected = [
            'number_of_talks' => '',
        ];

        $this->assertSame($expected, $action());
    }
}
