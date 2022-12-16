<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Subject;
use Exception;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class LibraryController extends Controller
{
	//use HasApiTokens;
	
	public function index()
	{
		try {
			$setting = Setting::where('key', 'allow-public-access')->where('value', 'false')->first();
			if ($setting === null) {
				throw new Exception('Forbidden');
			} else {
				$subjects = Subject::where('visibility', 1)->get();
				
				// foreach ($subjects as $subject) {
				// 	if ($subject->image_id !== null) {
				// 		$image[] = Image::find($subject->image_id)->first();
				// 	} else {
				// 		$image[] = null;
				// 	}
				// }

				// return response()->json([
				// 	'subjects' => $subjects,
				// 	'image' => $image,
				// 	'default' => [asset('storage/logo-150x150.png')],
				// ], 200);
				return response()->json($subjects, 200);
			}
		} catch (Exception $exc) {
			echo $exc->getMessage();
		}
	}

	public function projectsBelongsToSubject($id)
	{
		try {
			$setting = Setting::where('key', 'allow-public-access')->where('value', 'false')->first();
		
			if ($setting === null) {
				throw new Exception('Forbidden');
			} else {
				$projects = Project::where('subject_id', $id)->where('visibility', 1)->get();
				
				//dd($projects);
				//$image = array();
				$user = array();
				foreach ($projects as $project) {
					// if ($project->image_id !== null) {
					//$image[] = $project->image->url;
					// } else {
					// 	$image[] = null;
					// }
					$user[] = $project->user->name;
				}
				
				return response()->json([
					'projects' => $projects,
					'user' => $user,
					//'image' => $image,
					'default' => Storage::url('pattern_vue.png'),
				], 200);
				//return response()->json($projects, 200);
			}
		} catch (Exception $exc) {
			echo $exc->getMessage();
		}
	}
}
