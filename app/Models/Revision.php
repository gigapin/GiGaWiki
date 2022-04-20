<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Revision extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @param mixed $request
     * @param int $id
     * @param bool $initial
     *
     * @return void
     */
    public static function createRevision(mixed $request, int $id, bool $initial = true)
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
    public static function updateRevision(int $id, mixed $request)
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
    public static function showRevisionButton(string $slug)
    {
        $revision = Revision::where('slug', $slug)->first();
        if ($revision !== null) {
            return $revision;
        }
    }

    /**
     * @param mixed $value
     * 
     * @return Carbon
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value )->diffForHumans();
    }

    
}
