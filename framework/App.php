<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

/**
 *
 */
class App
{
	/**
   	 * [$handlesList description]
     * @var [type]
     */
	public static $handlesList = [];

	/**
     * [__construct description]
     */
	public function __construct()
	{
		foreach (self::$handlesList as $handle) {
			$handle->register($this);
		}
	}

	public function load($load)
	{
		$load->register();
	}
}
