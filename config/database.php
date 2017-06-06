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
        'dbtype'   => env('database')['dbtype'],
        'dbprefix' => env('database')['dbprefix'],
        'dbname'   => env('database')['dbname'],
        'dbhost'   => env('database')['dbhost'],
        'username' => env('database')['username'],
        'password' => env('database')['password']
    ]
];
