<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
