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
    public function __construct()
    {
        $config = App::$container->getSingle('config');
        $config = $config->config['nosql']['Memcached'];
        $redis = new rootMemcached();
        $redis->addServer($config['host'], $config['port']);
        App::$container->setSingle('memcached', $redis);
    }
}
