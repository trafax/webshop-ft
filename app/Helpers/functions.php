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
    function t($parent_id, $field, $locale = '', $default = '')
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
                // Meertalige SEO velden
                if (preg_match('/seo\[/i', $field))
                {
                    return $parent_id['seo'][str_replace(array('seo', '[', ']'),'',$field)];
                }
                else
                {
                    if ($locale == 'en' && $parent_id->$field == 'Nieuw')
                    {
                        return 'New';
                    }
                    if ($locale == 'de' && $parent_id->$field == 'Nieuw')
                    {
                        return 'Neu';
                    }

                    return $parent_id->$field;
                }
            }
            else
            {
                if ($default != '') {
                    return $default;
                }
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

if (! function_exists('it'))
{
    function it($parent_id, $value, $editor = false)
    {
        $locale = config('app.locale');

        $translation = Translation::where([
            'parent_id' => $parent_id,
            'field' => $parent_id
        ]);

        $translation->where('language_key', $locale);

        if (isset($translation->first()->value))
        {
            $return = $translation->first()->value;
        }
        else
        {
            $return = $value;
        }

        if (setting('translate') && Auth::user() && Auth::user()->role == 'admin')
        {
            $return = '<div class="m-0 p-0 translate-wrapper display-inline"><span class="translate-field ml-2" data-editor="'.$editor.'" data-enable_default="1" data-parent_id="'.$parent_id.'"><i class="fas fa-globe-europe"></i></span>'. $return . '</div>';
        }

        return $return;
    }
}
