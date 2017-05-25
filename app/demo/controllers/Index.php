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

    public function get()
    {
        return App::$app->request->get('username');
    }
}
