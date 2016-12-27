<?php

namespace Giga\Framework\Redirects;

use Giga\Framework\Redirects\Contracts\RedirectInterface;

class PageRedirect implements RedirectInterface
{

	public static function to($path)
	{
		if ( is_numeric($path) )
		{
			switch ($path) {
				case '404':
					# code...
					break;
			}
		}
			header('Location: ' . $path);
			exit;
	}

}