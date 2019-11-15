<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $seo = [
            'title' => t('settings', 'seo_title') ? t('settings', 'seo_title') : setting('seo_title'),
            'keywords' => t('settings', 'seo_keywords') ? t('settings', 'seo_keywords') : setting('seo_keywords'),
            'description' => t('settings', 'seo_description') ? t('settings', 'seo_description') : setting('seo_description')
        ];

        return view('homepage', compact('seo'));
    }
}
