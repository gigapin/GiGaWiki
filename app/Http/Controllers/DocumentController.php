<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Section;
use App\Models\Page;
use App\Models\Subject;

class DocumentController extends Controller
{
    /**
     * @param string $slug
     * 
     * @return void
     */
    public function index(string $slug)
    {
        
        $project = Project::where('slug', $slug)->first();
        $subject = Subject::where('id', $project->subject_id)->first();
        $sections = Section::where('project_id', $project->id)->where('visibility', 1)->get();
        $pages = Page::where('project_id', $project->id)->where('visibility', 1)->get();
        if(count($pages) < 1) {
            return view('documents.no-pages')->with('subject', $subject);
        }
        
        $doc = Page::where('project_id', $project->id)
            ->where('visibility', 1)
            ->orderBy('section_id')
            ->first();

        if($project->description !== null) {
            $description = true;
            $prev = null;
            $next = $doc->setNextDocPaginate($doc->getPage($doc->slug));
        } else {
            $prev = null;
            $next = $doc->setNextPaginate($doc->getPage($doc->slug));
        }

        return view('documents.index', [
            'project' => $project,
            'sections' => $sections, 
            'pages' => $pages,
            'description' => $description,
            'doc' => $doc,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    /**
     * @param string $projectSlug
     * @param string $sectionSlug
     * @param string $pageSlug
     * 
     * @return void
     */
    public function show(string $projectSlug, string $sectionSlug, string $pageSlug)
    {
        $project = Project::where('slug', $projectSlug)->first();
        $sections = Section::where('project_id', $project->id)->where('visibility', 1)->get();
        $pages = Page::where('project_id', $project->id)->where('visibility', 1)->get();
        $doc = Page::where('slug', $pageSlug)->first();
        
        return view('documents.show', [
            'project' => $project,
            'sections' => $sections, 
            'pages' => $pages,
            'doc' => $doc,
            'prev' => $doc->setPrevDocPaginate($doc->getPage($doc->slug)),
            'next' => $doc->setNextPaginate($doc->getPage($doc->slug)),
        ]);
    }

    /**
     * @param string $projectSlug
     * @param string $sectionSlug
     * 
     * @return void
     */
    public function section(string $projectSlug, string $sectionSlug)
    {
        $project = Project::where('slug', $projectSlug)->firstOrFail();
        $sections = Section::where('project_id', $project->id)->where('visibility', 1)->get();
        $section = Section::where('slug', $sectionSlug)->where('project_id', $project->id)->firstOrFail();
        $pages = Page::where('project_id', $project->id)->where('visibility', 1)->get();
        $doc = Page::where('section_id', $section->id)->first();

        return view('documents.section', [
            'sec' => $section,
            'project' => $project,
            'sections' => $sections, 
            'pages' => $pages,
            'doc' => $doc,
            'prev' => null, 
            'next' => $doc->setNextDocPaginate($doc->getPage($doc->slug)),
        ]);
    }
}
