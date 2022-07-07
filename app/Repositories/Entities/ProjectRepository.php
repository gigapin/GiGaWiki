<?php 

namespace App\Repositories\Entities;

use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Repositories\Contracts\ProjectInterface;

class ProjectRepository extends BaseRepository implements ProjectInterface 
{
    public function model() 
    {
        return Project::class;
    }

    /**
     * Undocumented function
     *
     * @param string $slug
     * @return mixed
     */
    public function getSections(string $slug): mixed
    {
        $projectId = $this->findIdFromSlug($slug);
        
        return Section::where('project_id', $projectId)
            ->paginate(config('app.page'));
    }

    /**
     * Undocumented function
     *
     * @param string $slug
     * @return Subject
     */
    public function findSubjectHasProject(string $slug): Subject
    {
        $project = $this->findSlug($slug);
    
        return Subject::findOrFail($project->subject_id);
    }

    /**
     * Undocumented function
     *
     * @param string $slug
     * @return void
     */
    public function deletePages(string $slug): void
    {
        $project = $this->findIdFromSlug($slug);
        $pages = Page::where('project_id', $project)->get();
        foreach ($pages as $page) {
            $page->delete();
        }
    }
}