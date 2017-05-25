<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */
namespace Framework\Handles;

use Framework\App;
use Framework\Handles\Handle;
use Framework\Exceptions\CoreHttpException;

class ErrorHandle implements Handle
{
    public function __construct()
    {
    }

    /**
     * 注册错误处理机制
     *
     * @return mixed
     */
    public function register(App $app)
    {
        register_shutdown_function([$this, 'shutdown']);
        set_error_handler([$this, 'errorHandler']);
    }

    /**
     * 脚本结束
     *
     * @return mixed
     */
    public function shutdown()
    {
        $error = error_get_last();
        if (empty($error)) {
            return;
        }
        $errorInfo = [
            'type'    => $error['type'],
            'message' => $error['message'],
            'file'    => $error['file'],
            'line'    => $error['line'],
        ];

        CoreHttpException::reponse($errorInfo);
    }

    public function errorHandler(
        $errorNumber,
        $errorMessage,
        $errorFile,
        $errorLine,
        $errorContext
    ) {

        $errorInfo = [
            'type'    => $errorNumber,
            'message' => $errorMessage,
            'file'    => $errorFile,
            'line'    => $errorLine,
            'context' => $errorContext,
        ];

        CoreHttpException::reponse($errorInfo);
    }
}
