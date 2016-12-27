<?php
namespace Giga\Framework\Sessions;


interface SessionInterface
{
    public static function get($name);

    public static function set($name, $value);

    public static function delete($name);

    public static function exists($name);

}