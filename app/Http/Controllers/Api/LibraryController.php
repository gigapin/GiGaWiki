<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Subject;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
  public function index()
  {
    $subjects = Subject::where('visibility', 1)->get();
    foreach ($subjects as $subject) {
      if ($subject->image_id !== null) {
        $image[] = Image::find($subject->image_id)->first();
      } else {
        $image[] = null;
      }
    }

    return response()->json([
      'subjects' => $subjects,
      'image' => $image,
      'default' => asset('storage/logo-150x150.png')
    ], 200);
  }

  public function projectsBelongsToSubject($id)
  {
    $projects = Project::where('subject_id', $id)->where('visibility', 1)->get();
    
    foreach ($projects as $project) {
      if ($project->image_id !== null) {
        $image[] = $project->image->url;
      } else {
        $image[] = null;
      }
    }
    
    return response()->json([
      'projects' => $projects,
      'image' => $image,
      'default' => Storage::url('pattern_vue.png')
    ], 200);
  }
}
