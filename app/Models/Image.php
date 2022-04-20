<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'path',
        'created_by',
        'updated_by',
        'type'
    ];

}
