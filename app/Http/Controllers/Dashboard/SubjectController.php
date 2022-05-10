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


/**
 *
 */
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
            'bodies' => Subject::latest()->paginate(env('APP_PAGE')),
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
    public function store(Request $request)
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
                    Tag::createTag($tag, $subject, 'subject');
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
        $this->getView()->setViews('subject', Subject::getSubject($slug)->id);

        return view('subjects.show', [
            'slug' => Subject::getSubject($slug),
            'projects' => Project::latestSubject(Subject::getSubject($slug)),
            'activities' => $this->getActivity()->showActivity('subject', Subject::getSubject($slug)->id),
            'rows' => Subject::all(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('subject', 4),
            'tags' => Tag::where('page_id', '=', Subject::getSubject($slug)->id)->get(),
            'featured' => $this->getImageFeatured(Subject::getSubject($slug)->id, 'Subject'),
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
            'slug' => Subject::getSubject($slug),
            'user' => User::loggedUser(),
            'tags' => Tag::where('page_type', 'subject')->where('page_id', Subject::getSubject($slug)->id)->get(),
            'featured' => $this->getImageFeatured(Subject::getSubject($slug)->id, 'Subject'),
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
    public function update(SubjectRequest $request, string $slug)
    {
        $this->authorize('update', Subject::class);

        $data = $this->getDataForm($request);
        
        if ($request->hasFile('featured') && $request->file('featured')->isValid()) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->updateImageFeatured('featured', $request->image_id)->id;
        }
        
        $subject = Subject::getSubject($slug);
        $subject->update($data);

        if (\request()->tags !== null) {
            Tag::updateTags(Subject::getSubject($slug), 'subject');
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
            'slug' => Subject::getSubject($slug),
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
    public function destroy(string $slug)
    {
        $this->authorize('delete', Subject::class);

        $subject = Subject::getSubject($slug);
        $this->getView()->deleteView('subject', $subject->id);
        $this->getActivity()->saveActivity('deleted', $subject->id, 'subject', $subject->name);
        $this->getActivity()->deleteActivity('subject', $subject->id);
        if($subject->image_id !== null) {
            $this->deleteFeatured($subject->image_id);
        }
        Tag::deleteTags($subject->id, 'subject');
        $subject->delete();
        // Deletes projects binded
        Subject::deleteProjects($subject);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }

    /**
     * @param $request
     * @return array
     */
    public function getDataForm($request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name);

        return $data;
    }
}
