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

use App\Demo\Models\TestTable;

/**
 * Demo Controller
 *
 * @desc default controller
 *
 * @author Gabriel <https://github.com/obdobriel>
 */
class Demo
{
    /**
     * 控制器构造函数
     */
    public function __construct()
    {
        # code...
    }

    /**
     * api
     */
    public function get()
    {
        $data = [
            'img'     => 'https://github.com/obdobriel/gab-php/blob/master/logo.jpeg?raw=true',
            'content' => 'A lightweight PHP framework for studying, Why do we need to build a PHP framework by ourself? Maybe the most of people will say "There have so many PHP frameworks be provided, but we still made a wheel?". My point is "Made a wheel is not our purpose, we will get some konwledge when making a wheel which is our really purpose".'
        ];
        $data = array_fill(0, 20, $data);
        return $data;
    }

    public function modelExample()
    {
        $testTableModel = new TestTable();
        return $testTableModel->modelFindDemo();
    }
}
