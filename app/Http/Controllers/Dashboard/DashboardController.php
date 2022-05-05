<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Models\Page;
use App\Models\Project;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends GigawikiController
{

    /**
     * Welcome screen and dashboard page.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $getUrl = array();
        $visited = $this->getView()->showAllViews();
        
        foreach ($visited as $view) {
            $model = "App\Models\\" . ucfirst($view->page_type);
            $getUrl[] = $model::find($view->page_id);
        }
        
        return view('dashboard', [
            'projects' => Project::where('user_id', Auth::id())->get(),
            'activities' => $this->getActivity()->showAllActivity(),
            'views' => $this->getView()->showAllViews(),
            'user' => User::loggedUser(),
            'project_latest' => Project::latestProject(3),
            'pages' => Page::latestPage(3),
            'project_all' => Project::all(),
            'rows' => Subject::all(),
            'url' => $getUrl,
            'name' => 'name'
        ]);
    }
}
