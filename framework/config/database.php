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

use Framework\Helper;

return [
    /* 默认配置 */
    'database' => [
        'dbtype'   => Helper::env('database')['dbtype'],
        'dbprefix' => Helper::env('database')['dbprefix'],
        'dbname'   => Helper::env('database')['dbname'],
        'dbhost'   => Helper::env('database')['dbhost'],
        'username' => Helper::env('database')['username'],
        'password' => Helper::env('database')['password']
    ]
];
