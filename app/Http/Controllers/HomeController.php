<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        echo "Hello GiGa World";
        dd();
        $subjects = Subject::where('visibility', 1)->get();
        $projects = Project::where('visibility', 1)->get();
        $subject = collect($subjects);
        $project = collect($projects);
        $slug = "";
        foreach ($project as $row) {
            $slug = $row->slug;
        }
        // dd();
        
        
        switch($subject->count() > 0) {
            case ($subject->count() > 0) && ($project->count() < 1):
                return redirect()->route('login');
                break;
            case ($subject->count() > 0) && ($project->count() === 1):
                return redirect()->route('document', $slug);
                break;
            case ($subject->count() > 0) && ($project->count() > 1):
                return redirect()->route('library');
                break;
        }

        return redirect()->route('login');
    }
}
