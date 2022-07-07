<?php 

namespace App\Repositories\Entities;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
  public function model() 
  {
    return User::class;
  }

  public function loggedUser()
  {
    return $this->model
      ->where('id', Auth::id())
      ->first();    
  }
}