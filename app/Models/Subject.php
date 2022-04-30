<?php

namespace App\Models;

use App\Traits\HasUploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subject extends Model
{
    use HasFactory, HasUploadFile;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'image_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'created_by');
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = htmlspecialchars($value, ENT_QUOTES); 
    }

    public function getDescriptionAttribute($value)
    {
        return htmlspecialchars_decode($value);
    }

    /**
     * getSubject
     *
     * @param mixed $slug
     * @return Subject
     */
    public static function getSubject(string $slug): Subject
    {
        return Subject::where('slug', $slug)->first();
    }

    /**
     *
     */
    public static function getProject(object $project)
    {
        return Subject::where('id', $project->subject_id)->first();
    }


    public static function deleteProjects(object $subject)
    {
        $projects = Project::where('subject_id', $subject->id)->get();
        foreach ($projects as $project) {
            $project->delete();
        }
    }

}
