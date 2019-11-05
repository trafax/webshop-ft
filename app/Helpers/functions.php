<?php

use App\Models\Country;
use App\Models\Setting;
use App\Models\Translation;

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

if (! function_exists('get_country_by_key'))
{
    function get_country_by_key($language_key)
    {
        $country = Country::where('language_key', $language_key)->first();

        return t($country, 'title');
    }
}

if (! function_exists('t'))
{
    function t($parent_id, $field, $locale = '')
    {
        if (! $locale)
        {
            $locale = config('app.locale');
        }

        $translation = Translation::where([
            'parent_id' => is_object($parent_id) ? $parent_id->id : $parent_id,
            'field' => $field
        ]);

        $translation->where('language_key', $locale);

        if (isset($translation->first()->value))
        {
            return $translation->first()->value;
        }
        else
        {
            if (is_object($parent_id))
            {
                return $parent_id->$field;
            }
            else
            {
                return '';
            }
        }
    }
}

if (! function_exists('price'))
{
    function price($price)
    {
        return @number_format($price, 2, ',', '.');
    }
}
