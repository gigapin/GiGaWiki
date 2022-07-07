<?php 

namespace App\Actions;

use App\Models\Revision;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RevisionAction
{
    /**
     * @param mixed $request
     * @param int $id
     * @param bool $initial
     *
     * @return void
     */
    public function createRevision(mixed $request, int $id, bool $initial = true): void
    {

        $revision = new Revision();
        $revision->project_id = $request['project_id'];
        $revision->section_id = $request['section_id'];
        $revision->page_id = $id;
        $revision->title = $request['title'];
        $revision->content = $request['content'];
        $revision->created_by = Auth::id();
        $revision->slug = Str::slug($request['title']);
        if ($initial === true) {
            $revision->summary = "Initial publish";
        }
        $revision->revision_number = 0;
        $revision->save();
    }

    /**
     * @param int $id
     * @param mixed $request
     *
     * @return mixed
     */
    public function updateRevision(int $id, mixed $request): mixed
    {
        $revision = Revision::where('page_id', $id)->first();
        $revision->project_id = $request['project_id'];
        $revision->section_id = $request['section_id'];
        $revision->title = $request['title'];
        $revision->content = $request['content'];
        $revision->created_by = Auth::id();
        $revision->slug = Str::slug($request['title']);
        $revision->summary = "";
        $revisions = Revision::where('title', $request['title'])->where('project_id', $request['project_id'])->get();
        $count = count($revisions);
        $revision->revision_number = $count++;
        $revision->save();

        return $revision;
    }

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function showRevisionButton(string $slug): mixed
    {
        $revision = Revision::where('slug', $slug)->first();
        if ($revision !== null) {
            return $revision;
        } else {
            return false;
        }
    }
}