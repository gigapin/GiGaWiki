<?php

namespace App\Repositories\Entities;

use App\Repositories\Contracts\CommentInterface;
use App\Models\Comment;
use App\Models\Project;

class CommentRepository extends BaseRepository implements CommentInterface
{
	public function model()
	{
		return Comment::class;
	}

  /**
   * @return mixed
   */
	public function hasParent(): mixed
  {
    $comments = Comment::all();
    foreach($comments as $comment) {
      if ($comment->parent_id !== null) {
        return $comment;
      }
    }
  }

  /**
   * @param  string
   * @return mixed
   */
  public function getComments(string $slug, string $class): mixed
  {
  	$page = $class::where('slug', $slug)->first();
    
    return Comment::where('page_id', $page->id)
	    ->where('parent_id', '=', null)
	    ->orderBy('updated_at', 'desc')
	    ->paginate(config('comment.page'));
  }

  /**
   * @param  string
   * @return mixed
   */
  public function getParentComments(string $slug, string $class): mixed
  {
  	$page = $class::where('slug', $slug)->first();

    return Comment::where('page_id', $page->id)
	    ->where('parent_id', '!=', null)
	    ->orderBy('updated_at', 'desc')
	    ->get();
  }
}