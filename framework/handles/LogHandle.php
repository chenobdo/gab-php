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

class LogHandle implements Handle
{
	/**
     * log file path
     *
     * @var string
     */
    private $logPath = '';

    /**
     * log file name
     *
     * @var string
     */
    private $logFileName = 'gab-php-framework-run';

    /**
     * 延时注册Loger实例到容器
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        App::$container->setSingle('logger', function () {
            return new LogHandle();
        });
    }

    /**
     * 构造函数
     *
     * construct
     */
    public function __construct()
    {
        /**
         * 日志目录检查
         *
         * check log path env config
         */
        $this->logPath = env('log_path');
        if (empty($this->logPath) || ! isset($this->logPath['path'])) {
            throw new CoreHttpException(400, 'log path is not defined');
        }
        $this->logPath = $this->logPath['path'];
        $this->logPath = App::$app->rootPath . $this->logPath;
        if (! file_exists($this->logPath)) {
            mkdir($this->logPath, 0777, true);
        }

        /**
         * 构建日志文件名称
         *
         * build log file name
         */
        $this->logFileName .= '.' . date('Ymd');
    }

    /**
     * write log
     *
     * @param  [type] $data log data
     * @return void
     */
    public function write($data = [])
    {
        Helper::log(
            $data,
            $this->logPath . $this->logFileName
        );
    }
}
