<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use App\Services\ViewService;
use App\Models\Setting;


class GigawikiController extends Controller
{
    /**
     * @return ActivityService
     */
    public function getActivity(): ActivityService
    {
        return new ActivityService();
    }

    /**
     * @return ViewService
     */
    public function getView(): ViewService
    {
        return new ViewService();
    }

    /**
     * Show or not comments.
     *
     * @return string
     */
    public function displayComments(): string
    {
        $setting = Setting::where('key', 'disable-comments')->first();
        
        return $setting->value === 'false' ? 'false' : 'true';  
    }




}
