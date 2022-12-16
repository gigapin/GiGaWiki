<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;

class DocumentController extends Controller
{
    public function project(string $slug, string $slug_page = null)
    {
        $project = Project::where('slug', $slug)->first();
        $sections = Section::where('project_id', $project->id)->get();
        $pages = Page::where('project_id', $project->id)->get();
        
        if ($slug_page !== null) {
            $first_page = Page::where('project_id', $project->id)->where('slug', $slug_page)->first();
        } else {
            $first_page = null;
        }
        
        return response()->json([
            'project' => $project,
            'sections' => $sections,
            'pages' => $pages,
            'first' => $first_page
        ], 200);
        
    }

    public function page(string $project, string $slug)
    {
        $project = Project::where('slug', $project)->first();
        $sections = Section::where('project_id', $project->id)->get();
        $pages = Page::where('project_id', $project->id)->get();
        
        $page = Page::where('slug', $slug)->first();
        $obj = new Page();
        $prev = $obj->setPrevPaginate($page);
        $next = $obj->setNextPaginate($page);

        return response()->json([
            'project' => $project,
            'sections' => $sections,
            'pages' => $pages,
            'page' => $page,
            'prev' => $prev,
            'next' => $next
        ], 200);
    }
}
