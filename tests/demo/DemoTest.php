<?php
/***********************************
 *             Gab PHP             *
 *                                 *
 * A light php framework for study *
 *                                 *
 *             Gabriel             *
 *  <https://github.com/obdobriel> *
 *                                 *
 ***********************************/

namespace Tests\Demo;

use Tests\TestCase;
use App\Demo\Controllers\Index;

class DemoTest extends TestCase
{
	/**
     *　演示测试
     */
    public function testDemo()
    {
        $index = new Index();

        $this->assertEquals(
            'Hello Gab PHP',
            $index->hello()
        );
    }
}
