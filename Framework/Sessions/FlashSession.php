<?php

namespace Giga\Framework\Sessions;

class FlashSession extends Session
{
    /**
     * @param $name
     * @param $value
     * @return null
     */
    public static function flash($name, $value = null)
    {
        if (self::exists($name))
        {
            $flash = self::get($name);
            self::delete($name);
            return $flash;
        }
        self::set($name, $value);
        return null;
    }
}