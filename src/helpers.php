<?php
/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://www.hrace009.com
 * @copyright Copyright (c) 2021.
 */

use hrace009\LaravelSettings\Facades\Settings;

if (!function_exists('settings')) {
    /**
     * @param string|null $key
     * @param null $default
     * @return mixed|Settings
     */
    function settings($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('settings');
        }

        return Settings::get($key, $default);
    }
}
