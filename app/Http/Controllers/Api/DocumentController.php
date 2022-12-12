<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;

class DocumentController extends Controller
{
    public function project(string $slug)
    {
        $project = Project::where('slug', $slug)->first();
        $sections = Section::where('project_id', $project->id)->get();
        $pages = Page::where('project_id', $project->id)->get();
        
        
        return response()->json([
            'project' => $project,
            'sections' => $sections,
            'pages' => $pages,
        ], 200);
        
    }

    public function page(string $project, string $slug)
    {
        $page = Page::where('slug', $slug)->first();

        return response()->json([
            'page' => $page,
        ], 200);
    }
}
