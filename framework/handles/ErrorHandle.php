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

class ErrorHandle implements Handle
{
	public function __construct()
    {
    }

	public function register()
	{
		register_shutdown_function([$this, 'shutdown']);
        set_error_handler([$this, 'errorHandler']);
	}

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

        // throw new Exception(json_encode($errorInfo), 500);
    }

    public function errorHandler(
        $errorNumber,
        $errorMessage,
        $errorFile,
        $errorLine,
        $errorContext)
    {
        $errorInfo = [
            'type'    => $errorNumber,
            'message' => $errorMessage,
            'file'    => $errorFile,
            'line'    => $errorLine,
            'context' => $errorContext,
        ];

        // throw new Exception(json_encode($errorInfo), 500);
    }
}
