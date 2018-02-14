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

namespace OpenCFP\Test\Unit;

use Localheinz\Test\Util\Helper;
use OpenCFP\PathInterface;
use OpenCFP\WebPath;

final class WebPathTest extends \PHPUnit\Framework\TestCase
{
    use Helper;

    public function testIsFinal()
    {
        $this->assertClassIsFinal(WebPath::class);
    }

    public function testImplementsPathInterface()
    {
        $this->assertClassImplementsInterface(PathInterface::class, WebPath::class);
    }

    /**
     * @test
     */
    public function uploadPathReturnsUploadPath()
    {
        $path = new WebPath();
        $this->assertSame(
            '/uploads/',
            $path->uploadPath()
        );
    }

    /**
     * @test
     */
    public function assetsPathReturnsAssetsPath()
    {
        $path = new WebPath();
        $this->assertSame(
            '/assets/',
            $path->assetsPath()
        );
    }
}
