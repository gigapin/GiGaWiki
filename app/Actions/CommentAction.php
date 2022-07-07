<?php 

namespace App\Actions;

use App\Models\Comment;


class CommentAction 
{
  /**
   * Get parent about a comment.
   *
   * @return Comment
   */
  public function hasParent(): Comment
  {
      $comments = Comment::all();
      foreach($comments as $comment) {
          if ($comment->parent_id !== null) {
              return $comment;
          }
      }
  }

  /**
   * Get comments belongs to a page.
   *
   * @param object $object
   * @return mixed
   */
  public function getComments(object $object): mixed
  {
      return Comment::where('page_id', $object->id)
          ->where('parent_id', '=', null)
          ->orderBy('updated_at', 'desc')
          ->paginate(config('comment.page'));
      
  }

  /**
   * Get parent comments belongs to a page.
   *
   * @param object $object
   * @return mixed
   */
  public function getParentComments(object $object): mixed
  {
      return Comment::where('page_id', $object->id)
          ->where('parent_id', '!=', null)
          ->orderBy('updated_at', 'desc')
          ->get();
  }
}