<?php 

namespace App\Services;

use App\Models\View;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ViewService 
{
    /**
     * Save visit pages.
     * 
     * @return void
     */
    public function setViews(string $page_type, int $page_id)
    {
        $getViews = View::where('page_type', $page_type)
            ->where('page_id', $page_id)
            ->first();

        if ($getViews === null) {
            $views = new View();
            $views['user_id'] = Auth::id();
            $views['page_id'] = $page_id;
            $views['page_type'] = $page_type;
            $views['views'] = 1;
            $views->save();
        } else {
            $getViews['user_id'] = Auth::id();
            $getViews['page_id'] = $page_id;
            $getViews['page_type'] = $page_type;
            $getViews['views'] = $getViews->views + 1;
            $getViews->update();
        }
    }

    /**
     * Delete visit record.
     * 
     * @return void
     */
    public function deleteView(string $page_type, int $page_id)
    {
        $getViews = View::where('page_type', $page_type)
            ->where('page_id', $page_id)
            ->first();

        if ($page_type === 'subject') {
            $this->deleteViewSubjects($page_id);
        }

        $getViews?->delete();
    }

    /**
     * Deleted from more visited box the projects binded to subject deleted.
     *
     * @param int $page_id
     * @return void
     */
    public function deleteViewSubjects(int $page_id)
    {
        $idProject = array();
        $projects = Project::where('subject_id', $page_id)->get();
        $views = View::where('page_type', 'project')->get();
        foreach ($projects as $project) {
            $idProject[] = $project->id;
        }
        foreach ($views as $view) {
            if(in_array($view->page_id, $idProject)) {
                $view->delete();
            }
        }
    }

    /**
     * Display views.
     * 
     * @return View
     */
    public function displayViews(string $page_type)
    {
        return View::where('page_type', $page_type)
            ->where('user_id', Auth::id())
            ->limit(4)
            ->orderByDesc('views')
            ->get();
    }

    /**
     * 
     */
    public function showAllViews()
    {
        return View::where('user_id', Auth::id())
            ->limit(4)
            ->orderBy('views', 'desc')
            ->get();
    }

    /**
     * 
     */
    public function pageTypeView(string $page, int $limit)
    {
        return View::where('user_id', Auth::id())
            ->where('page_type', $page)
            ->limit($limit)
            ->orderByDesc('views')
            ->get();
    }
}