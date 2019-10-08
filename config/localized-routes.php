<?php

use App\Models\Language;

return [

    /**
     * The locales you wish to support.
     */
    //'supported-locales' => ['en', 'nl', 'de'],
    'supported-locales' => [], // Those are added in AppServiceProvider.php

    /**
     * If you have a main locale and don't want
     * to prefix it in the URL, specify it here.
     *
     * 'omit_url_prefix_for_locale' => 'en',
     */
    'omit_url_prefix_for_locale' => 'nl',

    /**
     * If you want to automatically set the locale
     * for localized routes set this to true.
     */
    'use_locale_middleware' => true,

];
