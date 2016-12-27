<?php

namespace Giga\Framework\Auth;

use Giga\Framework\DB\DB;
use Giga\App\Configs\Config;
use Giga\Framework\Sessions\Session;
use Giga\Framework\Redirects\PageRedirect;

class Authenticate
{

    /**
    *   1. if exists...
    *   {
    *      1. set session
    *      2. 
    *   }
    *   @return log the user
    */

    public static function logInUser($needToLogUser)
    {

        // if ( Session::exists(Config::get('session.user_session')) )
        // {
        //     return Session::get(Config::get('session.user_session'));
        // }

        $db = DB::connect();

        $id = $needToLogUser->id;
        $user = $db->table('users')->where('id', $id)->first();


        if ($user)
        {
            $session = Config::get('session.user_session');

            if ( Session::exists ($session) )
            {
                Session::delete($session);
            }

            Session::set($session, $user);
            return true;
        }else
        {
            throw new \Exception("LoggIn Failed");
            
        }
    }
}