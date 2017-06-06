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

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\ConfigHandle;
use Framework\Handles\LogHandle;
use Framework\Handles\NosqlHandle;
use Framework\Handles\UserDefinedHandle;
use Framework\Handles\RouterHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

/**
 * 引入框架文件
 *
 * Require framework
 */
require(__DIR__ . '/App.php');

/**
 * 定义全局常量
 */

try {
    /**
     * Init framework
     */
    $app = new Framework\App(__DIR__ . '/..', function () {
        return require(__DIR__ . '/Load.php');
    });

    /*
     * Load all kinds of handles
     */

    $app->load(function() {
        // Loading config handle
        return new ConfigHandle();
    });

    $app->load(function () {
        // Loading log handle
        return new LogHandle();
    });

    $app->load(function () {
        // Loading error handle
        return new ErrorHandle();
    });

    $app->load(function () {
        //  加载异常处理机制 Loading exception handle.
        return new ExceptionHandle();
    });

    $app->load(function () {
        // Loading nosql handle
        return new NosqlHandle();
    });

    $app->load(function () {
        // Loading user-defined handle
        return new UserDefinedHandle();
    });

    $app->load(function () {
        // Loading router handle
        return new RouterHandle();
    });

    /**
     * 启动应用
     *
     * Start framework
     */
    $app->run(function() use ($app){
        return new Request($app);
    });

    /**
     * 响应结果
     *
     * Reponse
     *
     * 应用生命周期结束
     *
     * End
     */
    $app->response(function() {
        return new Response();
    });
} catch (CoreHttpException $e) {
    /**
     * 捕获异常
     *
     * Catch exception
     */
    $e->reponse($e);
}
