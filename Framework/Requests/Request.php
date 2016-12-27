<?php

namespace Giga\Framework\Requests;

class Request
{

	public static function all()
	{

		if (self::check() == 'post')
		{
			return $_POST;
		}elseif (self::check() == 'get')
		{
			return $_GET;
		}

	}

	public static function get($item, $type = null)
	{
		$value = '';
		if (!$type)
		{
			$type = self::check();
		}
		switch ($type) {
			case 'post':
				$value = $_POST[$item];
				break;

			case 'get' :
				$value = $_GET[$item];
				break;
		}	

		return $value;
	}

	public static function exists()
	{
		$type = self::check();

		switch ($type) {
			case 'post':
				$value = (!empty($_POST)) ? true : false;
				break;
			
			case 'get' :
				$value = (!empty($_GET)) ? true : false;
				break;
			default :
				return false;
		}
		return $value;
	}

	public static function check()
	{

		$type = $_SERVER["REQUEST_METHOD"];
		$val = '';

		switch ($type) {
			case 'POST':
				$val = 'post';
				break;

			case 'GET' :
				$val = 'get';
				break;
		}
		return $val;

	}

}