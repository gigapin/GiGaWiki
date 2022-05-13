<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_id', 
        'page_type', 
        'body', 
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function hasParent()
    {
        $comments = Comment::all();
        foreach($comments as $comment) {
            if ($comment->parent_id !== null) {
                return $comment;
            }
        }
    }

    public static function getComments(object $object)
    {
        return Comment::where('page_id', $object->id)
            ->where('parent_id', '=', null)
            ->orderBy('updated_at', 'desc')
            ->paginate(env('COMMENT_PAGE'));
        
    }

    public static function getParentComments(object $object)
    {
        return Comment::where('page_id', $object->id)
            ->where('parent_id', '!=', null)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
