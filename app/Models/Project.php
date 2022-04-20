<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Class Project
 * @package App/Models/Project
 */
class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'subject_id',
        'description',
        'image_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /**
     * @return HasOne
     */
    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class);
    }

    public function image():HasOne
    {
        return $this->hasOne(Project::class);
    }

    /**
     * Display latest projects updated.
     *
     * @param int $limit
     * @return mixed
     */
    public static function latestProject(int $limit): mixed
    {
        return Project::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * @param object $subject
     * @return mixed
     */
    public static function latestSubject(object $subject): mixed
    {
        return Project::where('subject_id', $subject->id)
            ->latest()
            ->paginate(env('APP_PAGE'));
    }

    /**
     * First project matching the slug.
     *
     * @param string $slug
     * @return mixed
     */
    public static function getProject(string $slug): mixed
    {
        return Project::where('slug', $slug)->firstOrFail();
    }

    /**
     * Get the user's projects.
     *
     * @return mixed
     */
    public static function getProjects(): mixed
    {
        return Project::where('user_id', Auth::id())
            ->latest()
            ->paginate(env('APP_PAGE'));
    }

    /**
     * Get sections matching project.
     *
     * @param object $project
     * @return mixed
     */
    public static function getSections(object $project): mixed
    {
        return Section::where('project_id', $project->id)
            ->paginate(env('APP_PAGE'));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public static function deletePages(int $project_id)
    {
        $pages = Page::where('project_id', $project_id)->get();
        foreach ($pages as $page) {
            $page->delete();
        }
    }
}
