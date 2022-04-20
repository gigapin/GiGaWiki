<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Project;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tags = Tag::all();
        $duplicate = [];
        $num = [];
        foreach ($tags as $tag) {
            $duplicate[] = $tag->name;
            $num[] = DB::table('tags')->where('name', '=', $tag->name)->count();
        }
        $collection = collect($duplicate);
        $combined = $collection->combine($num);

        return view('tags.index', [
            'tags' => $combined->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Tag
     */
    public function store(Request $request): Tag
    {
        return Tag::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function show(string $name)
    {
        $projects = array();
        $model = "App\Models\\";
        $tags = Tag::where('name', $name)->get();
        
        foreach ($tags as $tag) {
            $class = ucfirst($tag->page_type);
            $type = $model . $class;
            $projects[$tag->page_type] = $type::find($tag->page_id);
        }
        
        return view('tags.show', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        Tag::findOrFail($id)->delete();

        return redirect()->back();
    }
}
