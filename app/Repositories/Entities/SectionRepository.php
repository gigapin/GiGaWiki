<?php 

namespace App\Repositories\Entities;

use App\Repositories\Contracts\SectionInterface;
use App\Models\Section;
use App\Models\Page;
use App\Models\Project;


class SectionRepository extends BaseRepository implements SectionInterface
{
	
	public function model()
	{
		return Section::class;
	}

  /**
   * @param  string
   * @return mixed
   */
  public function getPages(string $slug): mixed
  {
  	$id = $this->findIdFromSlug($slug);

    return Page::where('section_id', $id)->paginate(config('app.page'));
  }

  /**
   * @param  string
   * @return Project
   */
  public function getProject(string $slug): Project
  {
  	$section = $this->findSlug($slug);

    return Project::where('id', $section->project_id)->firstOrFail();
  }

  /**
   * @param  string
   * @return void
   */
  public function deletePages(string $slug): void
  {
  	$id = $this->findIdFromSlug($slug);
    $pages = Page::where('section_id', $id)->get();
    foreach($pages as $page) {
        $page->delete();
    }
  }
}