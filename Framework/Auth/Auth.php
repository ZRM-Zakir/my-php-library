<?php

namespace Giga\Framework\Auth;

use Giga\App\Configs\Config;
use Giga\Framework\Auth\Authenticate;
use Giga\Framework\Sessions\Session;

class Auth
{

	public static function user()
	{
		$config = Config::get('session.user_session');

		if (Authenticate::logInUser(Session::get($config)))
		{
			return Session::get($config);
		}

	}

}