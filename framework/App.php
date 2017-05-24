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
  	 * [$App description]
  	 * @var string
  	 */
	public static $App = '';

	/**
     * [__construct description]
     */
	public function __construct()
	{
	}

	public function load($handle)
	{
		$handle()->register();
	}
}
