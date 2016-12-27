<?php

namespace Giga\Framework\Integers;

class Even
{
    /**
     * @return bool
     */
    public function get()
    {
        $array = func_get_args();

        if (count($array) < 2)
        {
            if ($array[0] % 2)
            {
                return false;
            }
            return true;
        }
    }
}