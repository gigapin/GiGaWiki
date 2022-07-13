<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\PageRequest;
use App\Models\Favorite;
use App\Models\Page;
use App\Models\Project;
use App\Models\Section;
use App\Models\Tag;
use App\Models\User;
use App\Traits\HasUploadFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Actions\RevisionAction;
use App\Actions\TagAction;
use App\Actions\CommentAction;


class PageController extends GigawikiController
{
    use HasUploadFile;

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(string $project, string $section)
    {
        $this->authorize('create', Page::class);

        return view('pages.create', [
            'section' => Section::where('slug', $section)->firstOrFail(),
            'project' => Project::where('slug', $project)->firstOrFail()
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     *
     * @return RedirectResponse
     */
    public function store(Request $request, RevisionAction $revisionAction, TagAction $tagAction): RedirectResponse
    {
        $slug = Str::slug($request->input('title'));
        $created = Page::create($this->getDataForm($request));
        $revisionAction->createRevision($this->getDataForm($request), $created->id);
        $project = Project::where('id', $request->input('project_id'))->firstOrFail();

        if(\request()->tags !== null) {
            foreach(\request()->tags as $tag) {
                if ($tag !== null) {
                    $tagAction->createTag(Auth::id(), $tag, $created, 'page');
                }
            }
        }
        $this->getActivity()->saveActivity('created', $created->id, 'page', $project->name);

        return redirect()
            ->route('pages.show', $slug)
            ->with('success', "Page created successfully");
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function show(Page $page, RevisionAction $revisionAction, CommentAction $commentAction, string $slug)
    {
        return view('pages.show', [
            'slug' => $this->page($slug),
            'section' => Section::where('id', $this->page($slug)->section_id)->first(), 
            'prev' => $page->setPrevPaginate($page->getPage($slug)),
            'next' => $page->setNextPaginate($page->getPage($slug)),
            'project' => Project::where('id', $this->page($slug)->project_id)->first(),
            'all_sections' => Section::where('project_id', $this->page($slug)->project_id)->get(),
            'pages' => Page::all(),
            'comments' => $commentAction->getComments($page->getPage($slug)),
            'parents' => $commentAction->getParentComments($page->getPage($slug)),
            'user' => User::loggedUser(),
            'revision' => $revisionAction->showRevisionButton($slug),
            'favorite' => Favorite::where('page_id', $this->page($slug)->id)->where('user_id', Auth::id())->where('page_type', 'pages')->first(),
            'url' => 'pages',
            'displayComments' => $this->displayComments()
        ]);
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function edit(string $slug)
    {
        $this->authorize('update', Page::class);

        return view('pages.edit', [
            'page' => $this->page($slug),
            'section' => Section::where('id', $this->page($slug)->section_id)->first(),
            'project' =>  Project::where('id', $this->page($slug)->project_id)->first(),
            'tags' => Tag::where('page_type', 'page')->where('page_id', $this->page($slug)->id)->get()
        ]);
    }

    /**
     * @param Page $page
     * @param PageRequest $request
     * @param string $slug
     *
     * @return RedirectResponse
     */
    public function update(Request $request, RevisionAction $revisionAction, TagAction $tagAction, string $slug): RedirectResponse
    {
        $update = $this->page($slug);
        $update->update($this->getDataForm($request));
        $revisionAction->createRevision($this->getDataForm($request), $update->id);
        if ($request->tags !== null) {
            $tagAction->updateTags($update, 'page');
        }

        return redirect()
            ->route('pages.show', $update->slug)
            ->with('success', 'Page updated successfully');
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return RedirectResponse
     */
    public function destroy(string $slug): RedirectResponse
    {
        $obj = $this->page($slug);
        $project = Project::where('id', $obj->project_id)->firstOrFail();
        $section = Section::where('id', $obj->section_id)->firstOrFail();
        $obj->delete();
        $this->getActivity()->saveActivity('deleted', $obj->id, 'page', $obj->slug);
        
        return redirect()
            ->route('sections.show', [
                $project->slug,
                $section->slug
            ])
            ->with('success', 'Page deleted successfully');
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function delete(string $slug)
    {
        $this->authorize('delete', Page::class);

        return view('pages.delete', [
            'page' => $this->page($slug)
        ]);
    }

    /**
     * @param mixed $request
     * @param null $revision
     *
     * @return mixed
     */
    private function getDataForm($request, $revision = null)
    {
        $data['section_id'] = $request->input('section_id');
        $data['project_id'] = $request->input('project_id');
        $data['title'] = $request->input('title');
        $data['content'] = $this->renderDom($request->content);
        $data['slug'] = Str::slug($request->input('title'));
        $data['page_type'] = 'page';
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        $data['owned_by'] = Auth::id();
        if ($revision !== null) {
            $data['current_revision'] = $revision->revision_number;
        }

        return $data;
    }

    /**
     * Get page.
     *
     * @param string $slug
     * @return mixed
     */
    private function page(string $slug): mixed
    {
        return Page::where('slug', $slug)->firstOrFail();
    }

}
