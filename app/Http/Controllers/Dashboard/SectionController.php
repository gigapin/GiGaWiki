<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Page;
use App\Models\User;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Str;
use App\Actions\CommentAction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\SectionRequest;
use Illuminate\Contracts\Foundation\Application;

class SectionController extends GigawikiController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function create(string $slug): View|Factory|Application
    {
        $this->authorize('create', Section::class);

        return view('sections.create', [
            'project' => $this->project($slug),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionRequest $request
     * @return RedirectResponse
     */
    public function store(SectionRequest $request): RedirectResponse
    {
        $section = Section::create($this->getDataForm($request));
        $this->getActivity()->saveActivity('created', $section->id, 'section');

        return redirect()
            ->route('projects.show', $section->project->slug)
            ->with('success', 'Section created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param string $project
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(CommentAction $comment, string $project, string $slug): Application|Factory|View
    {
        return view('sections.show', [
            //'section' => $this->section($slug),
            'slug' => $this->section($slug),
            'pages' => Page::where('section_id', $this->section($slug)->id)->paginate(config('app.page')),
            'comments' => $comment->getComments($this->section($slug)),
            'parents' => $comment->getParentComments($this->section($slug)),
            'user' => User::loggedUser(),
            'activities' => $this->getActivity()->showActivity('section', $this->section($slug)->id),
            'project' => $this->project($project),
            'subject' => Subject::where('id', $this->project($project)->subject_id)->firstOrFail(),
            'url' => 'subjects',
            'name' => 'name',
            'rows' => Section::all(),
            'displayComments' => $this->displayComments()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function edit(string $slug): View|Factory|Application
    {
        $this->authorize('update', Section::class);

        return view('sections.edit', [
            'slug' => $this->section($slug),
            'user' => User::loggedUser(),
            'project' => Project::where('id', $this->section($slug)->project_id)->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SectionRequest $request
     * @param string $slug
     * @return RedirectResponse
     */
    public function update(SectionRequest $request, string $slug): RedirectResponse
    {
        $update = $this->section($slug);
        $update->update($this->getDataForm($request));
        $section = Section::getSection($this->getDataForm($request)['slug']);
        $this->getActivity()->saveActivity('updated', $update->id, 'section', $update->title);

        return redirect()
<<<<<<< HEAD
            ->route('projects.show', $this->section($slug)->project->slug)
=======
            ->route('projects.show', $section->project->slug)
>>>>>>> origin/master
            ->with('success', 'Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function destroy(string $slug): RedirectResponse
    {
        $section = $this->section($slug);
        $project = $this->section($slug)->project->slug;
        
        $this->getActivity()->saveActivity('deleted', $section->id, 'section', $section->title);
        $this->getActivity()->deleteActivity('section', $section->id);
        $section->delete();

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Section deleted successfully');
    }

    /**
     * @param string $slug
     * @return Application|Factory|View
     */
    public function delete(string $slug): View|Factory|Application
    {
        $this->authorize('delete', Section::class);

        return view('sections.delete', [
            'section' => $this->section($slug),
            'user' => User::loggedUser()
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function getDataForm($request): mixed
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        return $data;
    }

    /**
     * Return project from slug.
     *
     * @param string $slug
     * @return mixed
     */
    private function project(string $slug): mixed
    {
        return Project::where('slug', $slug)->firstOrFail();
    }

    /**
     * Return section from slug.
     *
     * @param string $slug
     * @return mixed
     */
    private function section(string $slug): mixed
    {
        return Section::where('slug', $slug)->firstOrFail();
    }
}
