<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\PageRequest;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Page;
use App\Models\Project;
use App\Models\Revision;
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
            'section' => Section::getSection($section),
            'project' => Project::getProject($project)
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Page $page): RedirectResponse
    {
        $slug = Str::slug($request->input('title'));
        $created = Page::create($this->getDataForm($request));
        Revision::createRevision($this->getDataForm($request), $created->id);
        if(\request()->tags !== null) {
            foreach(\request()->tags as $tag) {
                if ($tag !== null) {
                    Tag::createTag($tag, $created, 'page');
                }
            }
        }
        $this->getActivity()->saveActivity('created', $created->id, 'page', $page->getProject($request->input('project_id'))->name);

        return redirect()->route('pages.show', $slug);
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function show(Page $page, string $slug)
    {
        return view('pages.show', [
            'slug' => $page->getPage($slug),
            'section' => $page->getSectionId($page->getPage($slug)),
            'prev' => $page->setPrevPaginate($page->getPage($slug)),
            'next' => $page->setNextPaginate($page->getPage($slug)),
            'project' => $page->getProjectId($page->getPage($slug)),
            'all_sections' => $page->getAllSections($page->getPage($slug)->project_id),
            'pages' => Page::all(),
            'comments' => Comment::getComments($page->getPage($slug)),
            'parents' => Comment::getParentComments($page->getPage($slug)),
            'user' => User::loggedUser(),
            'revision' => Revision::showRevisionButton($slug),
            'favorite' => Favorite::where('page_id', $page->getPage($slug)->id)->where('user_id', Auth::id())->where('page_type', 'pages')->first(),
            'url' => 'pages'
        ]);
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function edit(Page $page, string $slug)
    {
        $this->authorize('update', Page::class);

        return view('pages.edit', [
            'page' => $page->getPage($slug),
            'section' => $page->getSectionId($page->getPage($slug)),
            'project' => $page->getProjectId($page->getPage($slug)),
            'tags' => Tag::where('page_type', 'page')->where('page_id', $page->getPage($slug)->id)->get()
        ]);
    }

    /**
     * @param Page $page
     * @param PageRequest $request
     * @param string $slug
     *
     * @return RedirectResponse
     */
    public function update(Page $page, Request $request, string $slug): RedirectResponse
    {
        $update = $page->getPage($slug);
        $update->update($this->getDataForm($request));
        Revision::createRevision($this->getDataForm($request), $update->id);
        if ($request->tags !== null) {
            Tag::updateTags($update, 'page');
        }

        return redirect()
            ->route('pages.show', $update->slug)
            ->with('success', 'page updated successfully');
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return RedirectResponse
     */
    public function destroy(Page $page, string $slug): RedirectResponse
    {
        $obj = $page->getPage($slug);
        $obj->delete();
        $this->getActivity()->saveActivity('deleted', $obj->id, 'page', $obj->slug);

        return redirect()
            ->route('sections.show', [
                $page->getProjectId($obj)->slug,
                $page->getSectionId($obj)->slug
            ])
            ->with('success', 'Page deleted successfully');
    }

    /**
     * @param Page $page
     * @param string $slug
     *
     * @return Application|Factory|View
     */
    public function delete(Page $page, string $slug)
    {
        $this->authorize('delete', Page::class);

        return view('pages.delete', [
            'page' => $page->getPage($slug)
        ]);
    }

    /**
     * @param mixed $request
     * @param null $revision
     *
     * @return mixed
     */
    public function getDataForm($request, $revision = null)
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

}
