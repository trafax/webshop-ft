<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    public function set_language(Language $language)
    {
        $previous_path = trim(parse_url(URL::previous())['path'], '/');
        $previous_path_array = explode('/', $previous_path);
        $language_keys = Language::orderBy('sort')->get()->pluck('language_key')->toArray();

        if (in_array($previous_path_array[0], $language_keys))
        {
            $previous_path_array[0] = $language->language_key;

            if ($language->is_default == 1)
            {
                unset($previous_path_array[0]);
            }
        }
        else
        {
            $previous_path_array = Arr::prepend($previous_path_array, $language->language_key);

            if ($language->is_default == 1)
            {
                unset($previous_path_array[0]);
            }
        }

        $previous_changed_url = implode('/', $previous_path_array);

        return redirect($previous_changed_url);
    }
}
