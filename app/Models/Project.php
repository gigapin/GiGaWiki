<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


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
        'image_id',
        'visibility'
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
