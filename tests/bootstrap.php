<?php
/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://www.hrace009.com
 * @copyright Copyright (c) 2021.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

function storage_path($filename)
{
    return dirname(__DIR__) . '/tests/' . $filename;
}