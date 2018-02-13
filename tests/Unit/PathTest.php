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
use OpenCFP\Path;
use OpenCFP\PathInterface;

final class PathTest extends \PHPUnit\Framework\TestCase
{
    use Helper;

    public function testIsFinal()
    {
        $this->assertClassIsFinal(Path::class);
    }

    public function testImplementsPathInterface()
    {
        $this->assertClassImplementsInterface(PathInterface::class, Path::class);
    }

    /**
     * @test
     */
    public function uploadPathReturnsUploadPath()
    {
        $path = new Path('/home/folder/base');
        $this->assertSame(
            '/home/folder/base/web/uploads',
            $path->uploadPath()
        );
    }

    /**
     * @test
     */
    public function assetsPathReturnsAssetsPath()
    {
        $path = new Path('/home/folder/base');
        $this->assertSame(
            '/home/folder/base/web/assets',
            $path->assetsPath()
        );
    }
}
