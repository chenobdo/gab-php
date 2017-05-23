<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

use framework\handles\ErrorHandle;

/**
 * 定义全局常量
 */
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/..');

/**
 *
 */
require(ROOT_PATH . '/framework/App.php');
require(ROOT_PATH . '/framework/Load.php');

App::load(new Load());

App::$handlesList[] = new ErrorHandle();

new App();
