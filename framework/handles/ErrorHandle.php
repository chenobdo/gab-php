<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

namespace framework\handles

use framework\handles\Handle;

class ErrorHandle implements Handle
{
	public function __construct()
	{}

	public function register($app)
	{
		var_dump('error_handle');
	}
}
