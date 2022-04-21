<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\SectionRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

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
            'project' => Project::getProject($slug),
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
    public function show(string $project, string $slug): Application|Factory|View
    {
        return view('sections.show', [
            'section' => Section::getSection($slug),
            'slug' => Section::getSection($slug),
            'pages' => Section::getPages($slug),
            'comments' => Comment::getComments(Section::getSection($slug)),
            'parents' => Comment::getParentComments(Section::getSection($slug)),
            'user' => User::loggedUser(),
            'activities' => $this->getActivity()->showActivity('section', Section::getSection($slug)->id),
            'project' => Project::getProject($project),
            'subject' => Subject::getProject(Project::getProject($project)),
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
            'slug' => Section::getSection($slug),
            'user' => User::loggedUser(),
            'project' => Section::getProject(Section::getSection($slug))
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
        $update = Section::getSection($slug);
        $update->update($this->getDataForm($request));
        $this->getActivity()->saveActivity('updated', $update->id, 'section', $update->title);

        return redirect()
            ->route('projects.show', Section::getSection($slug)->project->slug)
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
        $section = Section::getSection($slug);
        $project = Section::getSection($slug)->project->slug;
        Section::deletePages($section->id);
        $this->getActivity()->saveActivity('deleted', $section->id, 'section', $section->title);
        $this->getActivity()->deleteActivity('section', $section->id);
        Section::getSection($slug)->delete();

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
            'section' => Section::getSection($slug),
            'user' => User::loggedUser()
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getDataForm($request): mixed
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        return $data;
    }
}
