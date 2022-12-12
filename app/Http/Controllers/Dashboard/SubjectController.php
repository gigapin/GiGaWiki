<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Http\Requests\Dashboard\SubjectRequest;
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
use Illuminate\Http\Request;
use App\Actions\TagAction;


class SubjectController extends GigawikiController
{
    use HasUploadFile;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {   
        return view('subjects.index', [
            'bodies' => Subject::latest()->paginate(config('app.page')),
            'activities' => $this->getActivity()->setActivity('subject'),
            'rows' => Subject::where('user_id', Auth::id())->get(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('subject', 4),
            'name' => 'name',
            'url' => 'subjects'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Subject::class);

        return view('subjects.create', [
            'rows' => Subject::all(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('subject', 4),
            'name' => 'name',
            'url' => 'subjects'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubjectRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(SubjectRequest $request, TagAction $tagAction)
    {
        $this->authorize('create', Subject::class);

        $data = $this->getDataForm($request);
        if ($request->hasFile('featured')) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->saveImageFeatured('featured')->id;
        }
        $subject = Subject::create($data);
        if(request()->tags !== null) {
            foreach(request()->tags as $tag) {
                if ($tag !== null) {
                    $tagAction->createTag(Auth::id(), $tag, $subject, 'subject');
                }
            }
        }
        $this->getActivity()->saveActivity('created', $subject->id, 'subject', $subject->name);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $slug)
    {
        $this->getView()->setViews('subject', $this->subject($slug)->id);
       
        return view('subjects.show', [
            'slug' => $this->subject($slug),
            'projects' => Project::where('subject_id', $this->subject($slug)->id)->latest()->paginate(config('app.page')),
            'activities' => $this->getActivity()->showActivity('subject', $this->subject($slug)->id),
            'rows' => Subject::all(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('subject', 4),
            'tags' => Tag::where('page_id', $this->subject($slug)->id)->get(),
            'featured' => $this->getImageFeatured($this->subject($slug)->id, 'Subject'),
            'name' => 'name',
            'url' => 'subjects'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(string $slug)
    {
        $this->authorize('update', Subject::class);

        return view('subjects.edit', [
            'slug' => $this->subject($slug),
            'user' => User::loggedUser(),
            'tags' => Tag::where('page_type', 'subject')->where('page_id', $this->subject($slug)->id)->get(),
            'featured' => $this->getImageFeatured($this->subject($slug)->id, 'Subject'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubjectRequest $request
     * @param string $slug
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SubjectRequest $request, TagAction $tagAction, string $slug)
    {
        $this->authorize('update', Subject::class);

        $data = $this->getDataForm($request);
        
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->updateImageFeatured('featured', $request->image_id)->id;
        }
        
        $subject = $this->subject($slug);
        $subject->update($data);

        if (\request()->tags !== null) {
            $tagAction->updateTags($subject, 'subject');
        }
        $this->getActivity()->saveActivity('updated', $subject->id, 'subject', $subject->name);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Display confirm form to delete element.
     *
     * @param string $slug
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(string $slug)
    {
        $this->authorize('delete', Subject::class);

        return view('subjects.delete', [
            'slug' => $this->subject($slug),
            'user' => User::loggedUser(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(TagAction $tagAction, string $slug)
    {
        $this->authorize('delete', Subject::class);

        $subject = $this->subject($slug);
        $this->getView()->deleteView('subject', $subject->id);
        $this->getActivity()->saveActivity('deleted', $subject->id, 'subject', $subject->name);
        $this->getActivity()->deleteActivity('subject', $subject->id);
        if($subject->image_id !== null) {
            $this->deleteFeatured($subject->image_id);
        }
        $tagAction->deleteTags($subject->id, 'subject');
        $subject->delete();
        // Deletes projects binded
        //Subject::deleteProjects($subject);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }

    /**
     * @param $request
     * @return array
     */
    private function getDataForm($request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name);

        return $data;
    }

    private function subject(string $slug)
    {
        return Subject::where('slug', $slug)->firstOrFail();
    }
}
