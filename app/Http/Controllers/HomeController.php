<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
   * Switch document or library page.
   *
   * @return void
   */
  public function index()
  {
    
    $subjects = Subject::where('visibility', 1)->get();
    $projects = Project::where('visibility', 1)->get();
    $subject = collect($subjects);
    $project = collect($projects);
    $slug = "";
    foreach ($project as $row) {
        $slug = $row->slug;
    }
    
    if (($subject->count() === 1) && $project->count() === 1) {
      return redirect()->route('document', $slug);
    }
      
    return redirect()->route('library');
  }
}
