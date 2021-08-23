<?php
if (!function_exists('mt_rand_float')) {
    function mt_rand_float($from, $to, $dec = 2)
    {
        $dec = pow(10, $dec);
        return mt_rand($from * $dec, $to * $dec) / $dec;
    }
}
