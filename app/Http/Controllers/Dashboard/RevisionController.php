<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Page;
use App\Models\Revision;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RevisionController extends GiGaWikiController
{
    
    /**
     * All resources revisionated.
     * 
     * @param string $project
     * @param int $page
     * 
     * @return Application|Factory|View
     */
    public function index(string $project, int $page)
    {
        $project = Project::where('slug', $project)->first();
        $revision = Revision::latest()->where('page_id', $page)->where('project_id', $project->id)->get();

        return view('revisions.index', [
            'revisions' => $revision,
            'user' => User::loggedUser(),
            'slug' => Page::where('id', $page)->first()
        ]);
    }

    /**
     * Preview about single revisioned page. 
     * 
     * @param string $project
     * @param int $page_id
     * @param int $id
     * 
     * @return Application|Factory|View
     */
    public function preview(string $project, int $page_id, int $id)
    {
        $project = Project::where('slug', $project)->first();
        $page = Page::find($page_id);

        $content = Revision::findOrFail($id);

        return view('pages.show', [
            'slug' => $page,
            'content' => $content->content,
            'section' => $page->getSectionId($page),
            'prev' => $page->setPrevPaginate($page),
            'next' => $page->setNextPaginate($page),
            'project' => $page->getProjectId($page),
            'all_sections' => $page->getAllSections($page_id),
            'pages' => Page::all(),
            'comments' => Comment::getComments($page),
            'parents' => Comment::getParentComments($page),
            'revision' => Revision::showRevisionButton($page->slug),
            'favorite' => Favorite::where('page_id', $page_id)->where('user_id', Auth::id())->where('page_type', 'page')->first(),
            'url' => 'pages',
            'displayComments' => $this->displayComments(),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Restore resource.
     * 
     * @param string $project
     * @param int $page_id
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function restore(string $project, int $page_id, int $id)
    {
        $project = Project::where('slug', $project)->first();
        $page = Page::find($page_id);
        $revision = Revision::findOrFail($id);
        $page->update([
            'updated_by' => Auth::id(),
            'content' => $revision->content,
            'current_revision' => $revision->id
        ]);

        return redirect()->route('pages.show', $page->slug);
    }

    /**
     * Delete resource.
     *
     * @param string $project
     * @param int $page_id
     * @param int $id
     * 
     * @return RedirectResponce
     */
    public function delete(string $project, int $page_id, int $id)
    {
        dd($id);
        Revision::findOrFail($id)->delete();
        if(Revision::where('id', $id)->first() === null) {
            return redirect()->route('pages.show', Page::find($page_id)->slug);
        }

        return redirect()->route('revisions.index', [$project, $page_id]);
    }
}
