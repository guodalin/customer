<?php

if (! function_exists('is_email')) {
    /**
     * @param $str
     *
     * @return bool
     */
    function is_email($str)
    {
        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }
}

if (! function_exists('is_mobile')) {
    /**
     * @param $str
     *
     * @return bool
     */
    function is_mobile($str)
    {
        return (bool) preg_match('/^1\d{10}$/', $str);
    }
}

if (! function_exists('should_sync_with_ucenter')) {
    /**
     * 是否需要同步到ucenter.
     *
     * @return bool
     */
    function should_sync_with_ucenter()
    {
        return in_array(config('auth.providers.users.driver'), ['bbs', 'ucenter']);
    }
}
