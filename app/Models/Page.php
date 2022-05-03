<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property mixed $section
 */
class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'owned_by',
        'project_id',
        'section_id',
        'page_type',
        'title',
        'slug',
        'content',
        'restricted',
        'current_revision'
    ];

    /**
     * Method section
     *
     * @return BelongsTo
     */
    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function setPage($request): mixed
    {
        $data = $request->only(['title', 'section_id']);
        $data['slug'] = Str::slug($request->title);
        $data['content'] = $request->content;
        $data['page_type'] = 'page';

        return $data;
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getPage(string $slug): mixed
    {
        return Page::where('slug', $slug)
            ->where('page_type', 'page')
            ->first();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public static function latestPage(int $limit): mixed
    {
        return Page::where('updated_by', Auth::id())
            ->where('page_type', 'page')
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPageId(int $id)
    {
        return Page::where('id', $id)->first();
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getSections(string $slug)
    {
        $page = new Page();
        $section = $page->section->$slug;
        return Page::where('section_id', $section->id)->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProject(int $id)
    {
        return Project::where('id', $id)->firstOrFail();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function getProjectId(object $page)
    {
        return Project::where('id', $page->project_id)->firstOrFail();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function getSectionId(object $page)
    {
        return Section::where('id', $page->section_id)->first();
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function getAllSections(int $page)
    {
        return Section::where('project_id', $page)->get();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function setNextPaginate(object $page)
    {
        return Page::where('project_id', $page->project_id)
            ->where('id', '>', $page->id)
            ->orderByDesc('id')
            ->first();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function setPrevPaginate(object $page)
    {
        return Page::where('project_id', $page->project_id)
            ->where('id', '<', $page->id)
            ->orderByDesc('id')
            ->first();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function setNextDocPaginate(object $page)
    {
        return Page::where('project_id', $page->project_id)
            ->where('id', '>', $page->id)
            ->orderBy('id')
            ->first();
    }

    /**
     * @param object $page
     * @return mixed
     */
    public function setPrevDocPaginate(object $page)
    {
        return Page::where('project_id', $page->project_id)
            ->where('id', '<', $page->id)
            ->orderByDesc('id')
            ->first();

    }
}
