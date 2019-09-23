<?php

use App\Models\Setting;

if (! function_exists('setting'))
{
    function setting($field)
    {
        $settings = array_column(Setting::all()->toArray(), 'value', 'field');

        if (array_key_exists($field, $settings))
        {
            return $settings[$field];
        }
    }
}
