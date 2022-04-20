<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\View;

class GigawikiController extends Controller
{
    /**
     * @return Activity
     */
    public function getActivity(): Activity
    {
        return new Activity();
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return new View();
    }




}
