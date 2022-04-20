<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'user_id',
        'type',
        'page_id',
        'page_type',
        'details',
        'ip'
    ];

    /**
     * Display all activities about an user in index page for each subject or project.
     *
     * @param $model
     * @return mixed
     */
    public function setActivity($model): mixed
    {
        return Activity::where('user_id', Auth::id())
            ->where('page_type', $model)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();
    }

    public static function showActivity(string $model, int $page_id)
    {
        return Activity::where('page_type', $model)
            ->where('user_id', Auth::id())
            ->where('page_id', $page_id)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();
    }

    /**
     * Display all activities about an user in dashboard page.
     *
     * @return mixed
     */
    public function showAllActivity(): mixed
    {
        return Activity::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit(4)
            ->get();
    }

    /**
     * Delete activities about page eliminated except deleted voice for tracking delete activity.
     *
     * @param string $model
     * @param int $page_id
     * @return void
     */
    public function deleteActivity(string $model, int $page_id)
    {
        $activities = Activity::where('page_type', $model)
            ->where('page_id', $page_id)
            ->where('type', '!=', 'deleted')
            ->get();

        foreach($activities as $activity) {
            $activity->delete();
        }
    }

    /**
     * Store a newly created activity in storage.
     *
     * @param string $type
     * @param $page_id
     * @param $page_type
     * @param string|null $details
     * @return void
     */
    public static function saveActivity(string $type, $page_id = null, $page_type = null, string $details = null)
    {
        $activity = new Activity();
        $activity->user_id = Auth::id();
        $activity->type = $type;
        $activity->page_id = $page_id;
        $activity->page_type = $page_type;
        $activity->details = $details;

        $activity->save();
    }

    public static function projectActivity(int $project_id): array
    {
        $data = array();
        $sections = Activity::where('page_type', 'section')->get();
        $lectures = Activity::where('page_type', 'lecture')->get();
        $projects = Project::where('id', '=', $project_id)->first();
        foreach ($sections as $section) {
            if(Section::where('id', $section->page_id)->where('project_id', $project_id)->first() !== null) {
                $data[] = Section::where('id', $section->page_id)->where('project_id', $project_id)->first();
            }

        }

        return $data;
    }

    /**
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     *
     * @param mixed $value
     * 
     * @return string
     */
    public function getPageTypeAttribute($value): string
    {
        return strtolower($value);
    }

}
