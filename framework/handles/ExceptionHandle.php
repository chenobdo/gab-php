<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

namespace Framework\Handles;

use Framework\Handles\Handle;
use Exception;

/**
 * 注册加载handle
 */
class ExceptionHandle implements Handle
{
	public function __construct()
	{}

	public function register()
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
