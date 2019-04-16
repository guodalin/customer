<?php

if (!function_exists('is_email')) {
    /**
     * @param $str
     *
     * @return boolean
     */
    function is_email($str)
    {
        return (boolean)filter_var($str, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('is_mobile')) {
    /**
     * @param $str
     *
     * @return boolean
     */
    function is_mobile($str)
    {
        return (boolean)preg_match('/^1\d{10}$/', $str);
    }
}
