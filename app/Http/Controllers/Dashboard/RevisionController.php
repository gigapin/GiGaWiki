<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Page;
use App\Models\User;
use App\Models\Project;
use App\Models\Favorite;
use App\Models\Revision;
use App\Actions\CommentAction;
use App\Actions\RevisionAction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GigawikiController;
use Illuminate\Http\RedirectResponse;

class RevisionController extends GiGaWikiController
{
    
    /**
     * All resources revisionated.
     * 
     * @param string $project
     * @param int $page
     * 
     * @return mixed
     */
    public function index(string $project, int $page): mixed
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
     * @return mixed
     */
    public function preview(
        RevisionAction $revisionAction, 
        CommentAction $commentAction, 
        string $project, 
        int $page_id, 
        int $id): mixed
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
            'comments' => $commentAction->getComments($page),
            'parents' => $commentAction->getParentComments($page),
            'revision' => $revisionAction->showRevisionButton($page->slug),
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
    public function restore(string $project, int $page_id, int $id): RedirectResponse
    {
        $project = Project::where('slug', $project)->first();
        $page = Page::findOrFail($page_id);
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
    public function delete(string $project, int $page_id, int $id): RedirectResponse
    {
        Revision::findOrFail($id)->delete();
        if(Revision::where('id', $id)->first() === null) {
            return redirect()->route('pages.show', Page::find($page_id)->slug);
        }

        return redirect()->route('revisions.index', [$project, $page_id]);
    }
}
