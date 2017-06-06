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

namespace Framework\Nosql;

use Framework\App;
use Memcached as rootMemcached;

/**
 * memcached操作类
 *
 */
class Memcached
{
    /**
     * 构造函数
     */
    static public function init()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['nosql']['Memcached'];
        $memcached  = new rootMemcached();
        $memcached->addServer($config['host'], $config['port']);
        return $memcached;
    }
}
