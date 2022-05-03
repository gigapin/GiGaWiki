<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Section;
use App\Models\Page;

class DocumentController extends Controller
{
    public function index(string $slug)
    {
        $project = Project::where('slug', $slug)->first();
        $sections = Section::where('project_id', $project->id)->where('visibility', 1)->get();
        $pages = Page::where('project_id', $project->id)->where('visibility', 1)->get();
        
        $doc = Page::where('project_id', $project->id)
            ->where('visibility', 1)
            ->orderBy('section_id')
            ->first();

        //dd($project->sections->slug);

        return view('layouts.document', [
            'project' => $project,
            'sections' => $sections, 
            'pages' => $pages,
            'doc' => $doc,
            'prev' => $doc->setPrevDocPaginate($doc->getPage($doc->slug)),
            'next' => $doc->setNextDocPaginate($doc->getPage($doc->slug)),
        ]);
    }

    public function show(string $projectSlug, string $sectionSlug, string $pageSlug)
    {
        $project = Project::where('slug', $projectSlug)->first();
        //$section = Section::where('slug', $sectionSlug)->first();
        $sections = Section::where('project_id', $project->id)->where('visibility', 1)->get();
        $pages = Page::where('project_id', $project->id)->where('visibility', 1)->get();
        $doc = Page::where('slug', $pageSlug)->first();
        //dd($doc->getPage($doc->slug)->id);
        return view('layouts.document', [
            'project' => $project,
            'sections' => $sections, 
            'pages' => $pages,
            'doc' => $doc,
            'prev' => $doc->setPrevDocPaginate($doc->getPage($doc->slug)),
            'next' => $doc->setNextDocPaginate($doc->getPage($doc->slug)),
        ]);
    }
}
