<?php 

namespace App\Repositories\Entities;

use App\Models\Project;
use App\Models\Subject;
use App\Repositories\Contracts\SubjectInterface;

class SubjectRepository extends BaseRepository implements SubjectInterface
{
  public function model() 
  {
    return Subject::class;
  }

  /**
   * Projects belongs to subject.
   *
   * @param string $slug
   * @return mixed
   */
  public function projectsBelongsToSubject(string $slug): mixed
  {
    $id = $this->findSlug($slug);

    return Project::where('subject_id', $id)->get();
  }

  /**
   * Projects belongs to subject.
   *
   * @param string $slug
   * @return mixed
   */
  public function latestProjectsBelongsToSubject(string $slug): mixed
  {
    $id = $this->findSlug($slug);

    return Project::where('subject_id', $id)
            ->latest()
            ->paginate(config('app.page'));
  }

  /**
   * Delete projects belongs to subject.
   *
   * @param string $slug
   * @return void
   */
  public function deleteProjectsBelongsToSubject(string $slug): void
  {
    $subject = $this->findSlug($slug);
    $projects = Project::where('subject_id', $subject->id)->get();
    foreach ($projects as $project) {
        $project->delete();
    }
  }
}