<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\GigawikiController;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends GigawikiController
{

    /**
     * @param string $model
     * @param string $slug
     * @return mixed
     */
    private function getNamespace(string $model, string $slug)
    {
        $class = $this->getClassName($model);
        $namespace = "App\Models\\$class";
        
        return $namespace::where('slug', $slug)->first();
    }

    /**
     * @param string $model
     * @return string
     */
    private function getClassName(string $model): string
    {
        return ucfirst(substr($model, 0, -1));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param string $model
     * @param string $slug
     * @return RedirectResponse
     */
    public function store(Request $request, string $model, string $slug): RedirectResponse
    {
        Comment::create($this->getDataForm($request, $this->getNamespace($model, $slug), $model));
        $this->getActivity()->saveActivity('commented', $this->getNamespace($model, $slug)->id, $this->getClassName($model));

        return redirect()->back();
    }

    /**
     * Reply a comment.
     *
     * @param Request $request
     * @param string $model
     * @param string $slug
     * @param int $id
     * @return RedirectResponse
     */
    public function reply(Request $request, string $model, string $slug, int $id): RedirectResponse
    {
        Comment::create($this->getDataForm($request, $this->getNamespace($model, $slug), $model, $id));
        $this->getActivity()->saveActivity('replyed comment', $this->getNamespace($model, $slug)->id, $this->getClassName($model));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $model
     * @param string $slug
     * @param int $comment
     * @return RedirectResponse
     */
    public function update(Request $request, string $model, string $slug, int $comment): RedirectResponse
    {
        Comment::find($comment)->update($this->getDataForm($request, $this->getNamespace($model, $slug), $model));
        $this->getActivity()->saveActivity('updated comment', $this->getNamespace($model, $slug)->id, $this->getClassName($model));

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $model
     * @param string $slug
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(string $model, string $slug,  int $id): RedirectResponse
    {
        $this->getActivity()->saveActivity('deleted comment', Comment::find($id)->page_id, $this->getClassName($model));
        Comment::find($id)->delete();

        return redirect()->back();
    }

    /**
     * @param $request
     * @param $item
     * @param $model
     * @param null $id
     * @return mixed
     */
    public function getDataForm($request, $item, $model, $id = null)
    {
        
        $comment['body'] = $request->body;
        $comment['user_id'] = Auth::id();
        $comment['page_id'] = $item->id;
        $comment['page_type'] = $this->getClassName($model);
        $comment['parent_id'] = $id;

        return $comment;
    }
}
