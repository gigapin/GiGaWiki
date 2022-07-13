<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Trait DomDocumentTrait
 * @package App\Traits
 */
trait HasUploadFile
{

    private string $storagePath = "uploads/";

    public function setStoragePath(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @return string
     */
    private function setImageName(): string
    {
        return Str::random(40);
    }

    /**
     * @return false|string
     */
    public function renderDom(string $request): bool|string
    {
        $dom = new \DomDocument();
        $dom->encoding = "UTF-8";
        $dom->loadHtml($request, LIBXML_HTML_NODEFDTD); //, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $name = $this->setImageName();
            $data = $img->getAttribute('src');
            // Explode (data:image/png;) if a new image is uploaded.
            $ex =  explode(';', $data);
            $extension = explode('data:image/', $ex[0]);

            if (array_key_exists(1, $ex)) {
                list($type, $data) = explode(';', $data);
                // Explode (base64,)
                list(, $data) = explode(',', $data);
                // Decode base64
                $dataDecode = base64_decode($data);
                
                $dir = $this->getStoragePath() . Auth::id();
                // Storing image.
                if ( ! is_dir(storage_path('app/public/' . $dir))) {
                    Storage::makeDirectory($dir);
                }
                $path = storage_path('app/public/' . $dir) . '/' . $name . '.' . $extension[1];
                
                file_put_contents($path, $dataDecode);
                // Remove old src attribute.
                $img->removeAttribute('src');
                // Set new src attribute with path.
                $srcPath = env('APP_URL') . '/storage/uploads/' . Auth::id() . '/' . $name  . '.' . $extension[1];
                $img->setAttribute('src', $srcPath);

                Image::create([
                    'name' => $name,
                    'url' => $srcPath,
                    'path' => $this->getStoragePath() . Auth::id() . "/" . $name . '.' . $extension[1],
                    'type' => 'post',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }

        }

        return str_replace(array('<html><body>', '</body></html>'), '', $dom->saveHTML());
    }

    /**
     * Storing featured image.
     *
     * @param string $fileName
     * @return string
     */
    public function renderFeatured(string $fileName): string
    {
        $file = request()->file($fileName);
        $name = $file->hashName();
        $dir = $this->getStoragePath() . Auth::id();
        if (! is_dir($dir)) {
            Storage::makeDirectory($dir);
        } 
        $file->storeAs($this->getStoragePath() . Auth::id(), $name, 'public');
        
        return $name;
    }

    /**
     * Save featured image in images table.
     *
     * @param string $image_name
     * @return Image
     */
    public function saveImageFeatured(string $image_name, string $type = 'cover')
    {
        return Image::create([
            'name' => $this->renderFeatured($image_name),
            'url' => env('APP_URL') . '/storage/uploads/' . Auth::id() . '/' . $this->renderFeatured($image_name),
            'path' => 'uploads/' . Auth::id() . '/' . $this->renderFeatured($image_name),
            'type' => $type,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
    }

    /**
     * @param string $image_name
     * @param int|null $image_id
     * @return Image
     */
    public function updateImageFeatured(string $image_name, int $image_id = null, string $type = 'cover')
    {
        if($image_id !== null) {
            $image = Image::find($image_id);
            if($image !== null) {
                if(file_exists(storage_path('app/public/' . $image->path))) { 
                    $image->delete();
                    Storage::disk('public')->delete($image->path);
                }
            }
        }

        return $this->saveImageFeatured($image_name, $type);
    }


    /**
     * @param int $id Id page
     * @param string $model model name
     *
     * @return string
     */
    public function getImageFeatured(int $id, string $model): string
    {
        if (env('DEFAULT_iMAGE') !== null) {
            $default_image = env('DEFAULT_IMAGE');
        } else {
            $default_image = "";
        }
       
        $class = "App\Models\\$model";
        $image_id = $class::find($id);

        if ($image_id->image_id !== null) {
            $image = Image::find($image_id->image_id);
            if ($image !== null) {
                if (file_exists(storage_path('app/public/' . $image->path))) {
                    $default_image = $image->url;
                } else {
                    $image->delete();
                }
            }
        }
        
        return $default_image;
    }

    /**
     * Delete image when the page is deleted.
     *
     * @param int $id
     *
     * @return void
     */
    public function deleteFeatured(int $id)
    {
        $image = Image::find($id);
        if ($image !== null) {
            if (file_exists(storage_path('app/public/' . $image->path))) {
                $image->delete();
                Storage::disk('public')->delete($image->path);
            }
        }
    }

}
