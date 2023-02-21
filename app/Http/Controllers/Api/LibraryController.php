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
			$setting = Setting::where('key', 'allow-public-access')->where('value', 'true')->first();
			if ($setting === null) {
				throw new Exception('Forbidden');
			} else {
				$subjects = Subject::where('visibility', 1)->get();
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
				$user = array();
				foreach ($projects as $project) {
					$user[] = $project->user->name;
				}
				
				return response()->json([
					'projects' => $projects,
					'user' => $user,
				], 200);
			}
		} catch (Exception $exc) {
			echo $exc->getMessage();
		}
	}
}
