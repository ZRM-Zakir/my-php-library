<?php

namespace Giga\Framework\Sessions;

class Session implements SessionInterface
{

    /**
     * @param $name
     * @return null
     */
    public static function get($name)
    {
        if (self::exists($name))
        {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function delete($name)
    {
        if (self::exists($name))
        {
            unset($_SESSION[$name]);
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function exists ($name)
    {
        if (isset( $_SESSION[$name] ))
        {
            return true;
        }
        return false;
    }
}