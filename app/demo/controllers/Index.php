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

namespace App\Demo\Controllers;

/**
 *
 */
class Index
{
    public function __construct()
    {
    }

    public function Hello()
    {
        echo 'Hello Gab PHP';
    }

    /*
     * 测试
     *
     * @param   string $username 用户名
     * @param   string $password 密码
     * @example domain/Demo/Index/get?username=test&password=123456
     * @return  json
     */
    public function get()
    {
        return \Framework\App::$container->getSingle('request')
                              ->get('password', '666');
    }
}
