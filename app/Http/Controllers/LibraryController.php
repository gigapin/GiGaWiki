<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Project;

class LibraryController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('visibility', 1)->get();
        
        return view('libraries.index', [
            'subjects' => $subjects
        ]);
    }

    public function show(string $slug)
    {
        $subject = Subject::where('slug', $slug)->firstOrFail();
        $project = Project::where('visibility', 1)->where('subject_id', $subject->id)->get();
        return view('libraries.show')
            ->with('projects', $project);
    }
}
