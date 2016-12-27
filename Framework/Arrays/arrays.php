<?php

namespace Giga\Framework\Arrays;


class arrays
{
    /**
     * @param $array
     * @param $num
     * @param bool $preserve
     * @return array|mixed
     */
    public static function getFromLast($array, $num, $preserve = false)
    {
        $value = self::getFirst(array_chunk(array_reverse($array), $num));
        if ($preserve)
        {
            $value = array_reverse(self::getFirst(array_chunk(array_reverse($array), $num)));
        }
        return $value;
    }

    /**
     * @param $array
     * @param $num
     * @return mixed
     */
    public static function getFromFirst($array, $num)
    {
        return self::getFirst(array_chunk($array, $num));
    }

    /**
     * @param $array
     * @return array
     */
    public static function getLast($array, $preserve = false)
    {
        $array = array_reverse($array, $preserve);
        return $array[0];
    }

    /**
     * @param $array
     * @return mixed
     */
    public static function getFirst($array)
    {
        return $array[0];
    }
}