<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Models\Section;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        'pages' => $pages
      ], 200);
    }

    public function page(string $project, string $slug)
    {
      // $project = Project::where('slug', $project)->first();
      // $sections = Section::where('project_id', $project->id)->get();
      // $pages = Page::where('project_id', $project->id)->get();
      $post = Page::where('slug', $slug)->first();

      return response()->json([
        // 'project' => $project,
        // 'sections' => $sections,
        // 'pages' => $pages,
        'post' => $post
      ], 200);
    }
}
