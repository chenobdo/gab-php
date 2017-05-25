<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

use Framework\Handles\ErrorHandle;
use Framework\Handles\ExceptionHandle;
use Framework\Handles\RouterHandle;
use Framework\Exceptions\CoreHttpException;
use Framework\Request;
use Framework\Response;

/**
 * 定义全局常量
 */

// 根目录
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

// 引入自加载类文件
require ROOT_PATH . '/framework/Load.php';
require ROOT_PATH . '/framework/App.php';

try {
    // 注册自加载
    Load::register();

    // 初始化应用
    $app = new \Framework\App();

    // 加载错误处理机制
    $app->load(
        function () {
            return new ErrorHandle();
        }
    );

    // 加载异常处理机制
    $app->load(
        function () {
            return new ExceptionHandle();
        }
    );

     // 加载路由机制
    $app->load(
        function () {
            return new RouterHandle();
        }
    );

    // 启动应用
    $app->run(function() {
        return new Request();
    });

    // 应用生命周期结束　响应结果
    $app->response(function() {
        return new Response();
    });
} catch (CoreHttpException $e) {
    CoreHttpException::reponse($e);
}
