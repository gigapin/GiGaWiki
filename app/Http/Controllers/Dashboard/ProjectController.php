<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\ProjectRequest;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\User;
use App\Traits\HasUploadFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProjectController extends GigawikiController
{
    use HasUploadFile;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('projects.index', [
            'projects' => Project::getProjects(),
            'activities' => $this->getActivity()->setActivity('project'),
            'rows' => Project::where('user_id', Auth::id())->get(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('project', 4),
            'url' => 'projects',
            'name' => 'name'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create(): View|Factory|Application
    {
        $this->authorize('create', Project::class);

        return view('projects.create', [
            'subjects' => Subject::all(),
            'projects' => Project::all(),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return RedirectResponse
     */
    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $this->getDataForm($request);
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->saveImageFeatured('featured')->id;
        }
        $project = Project::create($data);
        if(request()->tags !== null) {
            foreach(\request()->tags as $tag) {
                if ($tag !== null) {
                    Tag::createTag($tag, $project, 'project');
                }
            }
        }
        $this->getActivity()->saveActivity('created', $project->id, 'project', $project->name);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $slug): View|Factory|Application
    {
        $this->getView()->setViews('project', Project::getProject($slug)->id);

        return view('projects.show', [
            'slug' => Project::getProject($slug),
            'rows' => Project::all(),
            'sections' => Project::getSections(Project::getProject($slug)),
            'subject' => Subject::find(Project::getProject($slug)->subject_id),
            'comments' => Comment::getComments(Project::getProject($slug)),
            'parents' => Comment::getParentComments(Project::getProject($slug)),
            'user' => User::loggedUser(),
            'views' => $this->getView()->displayViews('project'),
            'activities' => $this->getActivity()->showActivity('project', Project::getProject($slug)->id),
            'featured' => $this->getImageFeatured(Project::getProject($slug)->id, 'Project'),
            'name' => 'name',
            'url' => 'projects',
            'tags' => Tag::where('page_type', 'project')->where('page_id', Project::getProject($slug)->id)->get(),
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
        $this->authorize('update', Project::class);

        return view('projects.edit', [
            'slug' => Project::getProject($slug),
            'rows' => Project::getProjects(),
            'subjects' => Subject::all(),
            'activities' => $this->getActivity()->showActivity('project', Project::getProject($slug)->id),
            'user' => User::loggedUser(),
            'tags' => Tag::where('page_type', '=', 'project')->where('page_id', Project::getProject($slug)->id)->get(),
            'featured' => $this->getImageFeatured(Project::getProject($slug)->id, 'Project'),
            'url' => 'projects',
            'name' => 'name',
            'views' => $this->getView()->displayViews('project'),
            'allTags' => Tag::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param string $slug
     * @return RedirectResponse
     */
    public function update(ProjectRequest $request, string $slug)
    {
        $data = $this->getDataForm($request);
        
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->updateImageFeatured('featured', $request->image_id)->id;
        }
        $project = Project::getProject($slug);
        $project->update($data);

        if(request()->tags !== null) {
            Tag::updateTags($project, 'project');
        }
        $this->getActivity()->saveActivity('updated', $project->id, 'project', $project->name);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Display confirm form to delete element.
     *
     * @param $slug
     * @return Application|Factory|View
     */
    public function delete($slug): View|Factory|Application
    {
        $this->authorize('delete', Project::class);

        return view('projects.delete', [
            'slug' => Project::getProject($slug),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function destroy(string $slug): RedirectResponse
    {
        $project = Project::getProject($slug);
        $this->getView()->deleteView('project', Project::getProject($slug)->id);
        $this->getActivity()->saveActivity('deleted', Project::getProject($slug)->id, 'project', $project->name);
        $this->getActivity()->deleteActivity('project', $project->id);
        if($project->image_id !== null) {
            $this->deleteFeatured($project->image_id);
        }
        Tag::deleteTags($project->id, 'project');
        $project->delete();
        Project::deletePages($project->id);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getDataForm($request): mixed
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['name']);

        return $data;
    }
}
