<?php

namespace App\Models;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Hasmany;


class Section extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 
        'title', 
        'slug', 
        'description'
    ];

    /**
     * Method project
     *
     * @return BelongsTo
     */
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Method pages
     *
     * @return HasMany
     */
    public function pages() : HasMany
    {
        return $this->hasMany(Page::class);
    }

    public static function getSections()
    {
        return Section::latest()->paginate(env('APP_PAGE'));
    }

    public static function getSection(string $slug)
    {
        return Section::where('slug', $slug)->firstOrFail();
    }

    public static function getProject(object $section)
    {
        return Project::where('id', $section->project_id)->first();
    }

    public static function getPages(string $slug)
    {
        return Page::where('section_id', Section::getSection($slug)->id)
            ->paginate(env('APP_PAGE'));
    }

    public static function deletePages(int $section_id)
    {
        $pages = Page::where('section_id', $section_id)->get();
        foreach($pages as $page) {
            $page->delete();
        }
    }
}
