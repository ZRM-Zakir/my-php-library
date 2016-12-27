<?php
namespace Giga\Framework\Hashs;

class Hash
{
    public static function make( $value, $salt = '' )
    {
        return hash('sha256', $value . $salt );
    }

    public static function salt($length)
    {
        return mcrypt_create_iv($length);
    }

}