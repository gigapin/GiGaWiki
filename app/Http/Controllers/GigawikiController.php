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
    public function getActivity()
    {
        return new ActivityService();
    }

    /**
     * @return ViewService
     */
    public function getView()
    {
        return new ViewService();
    }

    public function displayComments()
    {
        $setting = Setting::where('key', 'disable-comments')->first();
        
        return $setting->value === 'false' ? 'false' : 'true';
        
    }




}
