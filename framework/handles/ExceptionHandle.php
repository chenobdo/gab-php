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

namespace Framework\Handles;

use Framework\App;
use Framework\Handles\Handle;
use Framework\Exceptions\CoreHttpException;
use Exception;

/**
 * 未捕获异常注册加载handle
 */
class ExceptionHandle implements Handle
{
    public function __construct()
    {
    }

    public function register(App $app)
    {
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($exception)
    {
        $exceptionInfo = [
            'number'  => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'trace'   => $exception->getTrace(),
        ];

        throw new Exception(json_encode($exceptionInfo), 500);
    }
}
