<?php 

namespace App\Repositories\Entities;

use App\Repositories\Contracts\BaseInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository implements BaseInterface
{
  /**
   * Undocumented variable
   *
   * @var [type]
   */
  protected $model;

  /**
   * Undocumented function
   */
  public function __construct()
  {
    $this->model = $this->getModelClass();
  }

  /**
   * Undocumented function
   *
   * @return mixed
   */
  protected function getModelClass(): mixed
  {
    if (! method_exists($this, 'model')) {
      throw new Exception('Model not defined');
    }

    return app()->make($this->model());
  }

  /**
   * Get all resources.
   *
   * @return mixed
   */
  public function all(): mixed
  {
    return $this->model->get();
  }

  /**
   * Find a resource from an ID.
   *
   * @param int $id
   * @return mixed
   */
  public function find(int $id): mixed
  {
    return $this->model->findOrFail($id);
  }

  /**
   * Find a resource from slug.
   *
   * @param string $slug
   * @return mixed
   */
  public function findSlug(string $slug): mixed
  {
    return $this->model
      ->where('slug', $slug)
      ->firstOrFail();
  }

  /**
   * Get Id from slug.
   *
   * @param string $slug
   * @return mixed
   */
  public function findIdFromSlug(string $slug): mixed
  {
    $record = $this->findSlug($slug);
    
    return $record->id;
  }

  /**
   * Find some resources from a detailed request.
   *
   * @param string $column
   * @param int|string $value
   * @return mixed
   */
  public function findWhere(string $column, int|string $value): mixed
  {
    return $this->model
      ->where($column, $value)
      ->get();
  }

  /**
   * Undocumented function
   *
   * @param string $column
   * @param string $value
   * @return mixed
   */
  public function findWhereFirst(string $column, string $value): mixed
  {
    return $this->model
      ->where($column, $value)
      ->firstOrFail();
  }

  /**
   * Undocumented function
   *
   * @param string $column
   * @param integer|string $value
   * @return mixed
   */
  public function wherePaginate(string $column, int|string $value): mixed
  {
    return $this->model
      ->where($column, $value)
      ->paginate(config('app.page'));
  }

  /**
   * Undocumented function
   *
   * @param array $data
   * @return mixed
   */
  public function create(array $data): mixed
  {
    return $this->model->create($data);
  }

  /**
   * Undocumented function
   *
   * @param string $slug
   * @param array $data
   * @return mixed
   */
  public function update(string $slug, array $data): mixed
  {
    $record = $this->findSlug($slug);
    $record->update($data);
    return $record;
  }

  /**
   * Undocumented function
   *
   * @param string $slug
   * @return mixed
   */
  public function delete(string $slug): mixed
  {
    $record = $this->findSlug($slug);
    $record->delete();
    return $record;
  }

  /**
   * Undocumented function
   *
   * @return mixed
   */
  public function allBelongsUser(): mixed
  {
    return $this->model
      ->where('user_id', Auth::id())
      ->get();
  }

  /**
   * Undocumented function
   *
   * @return mixed
   */
  public function paginate(): mixed
  {
    return $this->model
      ->latest()
      ->paginate(config('app.page'));
  }

  /**
   * Undocumented function
   *
   * @return mixed
   */
  public function latestBelongsUser(): mixed
  {
    return $this->model
      ->where('user_id', Auth::id())
      ->latest()
      ->paginate(config('app.page'));
  }
}