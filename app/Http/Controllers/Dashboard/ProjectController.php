<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Section;
use App\Models\Subject;
use App\Actions\TagAction;
use Illuminate\Support\Str;
use App\Traits\HasUploadFile;
use App\Actions\CommentAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\ProjectRequest;
use Illuminate\Contracts\Foundation\Application;

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
            'projects' => Project::where('user_id', Auth::id())->latest()->paginate(config('app.page')),
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
     * @return void
     * @throws \Exception
     */
    public function create()
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
    public function store(ProjectRequest $request, TagAction $tagAction): RedirectResponse
    {
        $data = $this->getDataForm($request);
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->saveImageFeatured('featured')->id;
        }
        
        $project = Project::create($data);
        
        if(request()->tags !== null) {
            foreach(request()->tags as $tag) {
                if ($tag !== null) {
                    $tagAction->createTag(Auth::id(), $tag, $project, 'project');
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
    public function show(CommentAction $commentAction, string $slug): View|Factory|Application
    {
        $this->getView()->setViews('project', $this->project($slug)->id);

        return view('projects.show', [
            'slug' => $this->project($slug),
            'rows' => Project::all(),
            'sections' => Section::where('project_id', $this->project($slug)->id)->paginate(config('app.page')),
            'subject' => Subject::find($this->project($slug)->subject_id),
            'comments' => $commentAction->getComments($this->project($slug)),
            'parents' => $commentAction->getParentComments($this->project($slug)),
            'user' => User::loggedUser(),
            'views' => $this->getView()->displayViews('project'),
            'activities' => $this->getActivity()->showActivity('project', $this->project($slug)->id),
            'featured' => $this->getImageFeatured($this->project($slug)->id, 'Project'),
            'name' => 'name',
            'url' => 'projects',
            'tags' => Tag::where('page_type', 'project')->where('page_id', $this->project($slug)->id)->get(),
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
            'slug' => $this->project($slug),
            'rows' => Project::where('user_id', Auth::id())->latest()->paginate(config('app.page')),
            'subjects' => Subject::all(),
            'activities' => $this->getActivity()->showActivity('project', $this->project($slug)->id),
            'user' => User::loggedUser(),
            'tags' => Tag::where('page_type', '=', 'project')->where('page_id', $this->project($slug)->id)->get(),
            'featured' => $this->getImageFeatured($this->project($slug)->id, 'Project'),
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
    public function update(ProjectRequest $request, TagAction $tagAction, string $slug)
    {
        $data = $this->getDataForm($request);
        
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->updateImageFeatured('featured', $request->image_id)->id;
        }
        
        $project = $this->project($slug); 
        $project->update($data);

        if(request()->tags !== null) {
            $tagAction->updateTags($project, 'project');
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
            'slug' => $this->project($slug),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return RedirectResponse
     */
    public function destroy(TagAction $tagAction, string $slug): RedirectResponse
    {
        $project = $this->project($slug);
        $this->getView()->deleteView('project', $this->project($slug)->id);
        $this->getActivity()->saveActivity('deleted', $this->project($slug)->id, 'project', $this->project($slug)->name);
        $this->getActivity()->deleteActivity('project', $this->project($slug)->id);
        if($this->project($slug)->image_id !== null) {
            $this->deleteFeatured($this->project($slug)->image_id);
        }
        $tagAction->deleteTags($this->project($slug)->id, 'project');
        $project->delete();
        //Project::deletePages($this->project($slug)->id);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    /**
     * @param $request
     * @return mixed
     */
    private function getDataForm($request): mixed
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name);

        return $data;
    }

    /**
     * Return project from a slug.
     *
     * @param string $slug
     * @return mixed
     */
    private function project(string $slug): mixed
    {
        return Project::where('slug', $slug)->firstOrFail();
    }
}
