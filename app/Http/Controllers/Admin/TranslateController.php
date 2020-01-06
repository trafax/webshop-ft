<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Support\Facades\Redirect;

class TranslateController extends Controller
{
    public function modal()
    {
        return view('language.admin.partials.modal');
    }

    public function store(Request $request)
    {
        Translation::where(['parent_id' => $request->get('parent_id'), 'field' => $request->get('field')])->delete();
        foreach ($request->get('translate') as $language_key => $value)
        {
            if ($value)
            {
                $translation = new Translation();
                $translation->fill([
                    'parent_id' => $request->get('parent_id'),
                    'language_key' => $language_key,
                    'field' => $request->get('field'),
                    'value' => $value
                ]);
                $translation->save();
            }
        }

        //return redirect()->back() . '' . $request->get('tab');
        return Redirect::to(redirect()->back()->getTargetUrl() . $request->get('tab'));
    }
}
