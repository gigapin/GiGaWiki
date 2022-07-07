<?php 

namespace App\Repositories\Entities;

use App\Repositories\Contracts\PageInterface;
use App\Models\Page;
use App\Models\Project;

class PageRepository extends BaseRepository implements PageInterface
{
	public function model()
	{
		return Page::class;
	}

	/**
   * @param int $id
   * @return mixed
   */
  public function getProject(int $id): mixed
  {
    return Project::where('id', $id)->firstOrFail();
  }

  /**
   * @param string $slug
   * @return mixed
   */
  public function setNextPaginate(string $slug): mixed
  {
  	$page = $this->findSlug($slug);

    return $this->model->where('project_id', $page->project_id)
      ->where('id', '>', $page->id)
      ->orderBy('id')
      ->first();
  }

  /**
   * @param string $slug
   * @return mixed
   */
  public function setPrevPaginate(string $slug): mixed
  {
  	$page = $this->findSlug($slug);

    return $this->model->where('project_id', $page->project_id)
      ->where('id', '<', $page->id)
      ->orderByDesc('id')
      ->first();
  }
}