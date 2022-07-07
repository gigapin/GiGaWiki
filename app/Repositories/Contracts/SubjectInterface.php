<?php 

namespace App\Repositories\Contracts;

interface SubjectInterface 
{
  public function projectsBelongsToSubject(string $slug);
  
  public function latestProjectsBelongsToSubject(string $slug);

  public function deleteProjectsBelongsToSubject(string $slug);
}