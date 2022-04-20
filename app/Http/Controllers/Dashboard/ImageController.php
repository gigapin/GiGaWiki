<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ImageController extends Controller
{

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(): JsonResponse
    {
        $project = new Project();
        $project->id = 0;
        $project->exists = true;
        $image = $project->addMediaFromRequest('upload')
            ->toMediaCollection('images');

        return response()->json([
            'url' => $image->getUrl('thumb') //'https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/800px-PHP-logo.svg.png'
        ]);
    }
}
