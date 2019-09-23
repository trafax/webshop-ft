<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.admin.index');
    }

    public function store(Request $request)
    {
        Setting::truncate();

        foreach ($request->all() as $field => $value)
        {
            if ($field != '_token')
            {
                $setting = new Setting();
                $setting->field = $field;
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect()->back()->with('message', 'Instellingen succesvol opgeslagen!');
    }
}
