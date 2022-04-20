<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use App\Services\ViewService;

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




}
