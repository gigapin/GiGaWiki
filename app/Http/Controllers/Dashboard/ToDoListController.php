<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Project;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GigawikiController;
use Illuminate\View\View;

class ToDoListController extends GigawikiController
{
    /**
     * Display a listing of the resource.
     *
     * @param string $project
     * @return View
     */
    public function index(string $project): View
    {
        $project_slug = Project::where('slug', $project)->first();

        return view('todolists.index', [
            'todolists' => ToDoList::where('project_id', $project_slug->id)->get(),
            'activities' => $this->getActivity()->setActivity('project'),
            'rows' => Project::where('user_id', Auth::id())->get(),
            'user' => User::loggedUser(),
            'views' => $this->getView()->pageTypeView('project', 4),
            'url' => $project_slug->slug,
            'name' => 'name'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(string $project): View
    {
        //dd($project);
        $project_slug = Project::where('slug', $project)->first();

        return view('todolists.create', $project_slug->slug);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return 
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
