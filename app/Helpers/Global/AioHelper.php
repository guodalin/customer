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

if (!function_exists('should_sync_with_ucenter')) {
    /**
     * 是否需要同步到ucenter
     *
     * @return boolean
     */
    function should_sync_with_ucenter()
    {
        return in_array(config('auth.providers.users.driver'), ['bbs', 'ucenter']);
    }
}
