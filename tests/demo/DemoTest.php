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
use Framework\App;

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
             App::$app->get('demo/index/hello')
        );
    }
}
