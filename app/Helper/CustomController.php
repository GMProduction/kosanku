<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

/**
 * Class CustomController
 * @package App\Helper
 */
class CustomController extends Controller
{

    /**
     * @param string $field
     *
     * @return string
     */
    public function generateImageName($field = '')
    {
        $value = '';
        if (request()->hasFile($field)) {
            $files     = request()->file($field);
            $extension = $files->getClientOriginalExtension();
            $name      = $this->uuidGenerator();
            $value     = $name.'.'.$extension;
        }

        return $value;
    }

    //disk setting on app/config/filesystem

    /**
     * @param $field
     * @param string $targetName
     * @param string $disk
     *
     * @return bool
     */
    public function uploadImage($field, $targetName = '', $disk = 'upload')
    {
        $file = request()->file($field);

        return Storage::disk($disk)->put($targetName, File::get($file));
    }

    /**
     * @return string
     */
    public function uuidGenerator()
    {
        return Uuid::uuid1()->toString();
    }
    /**
     * @param $entity
     */
    public function unlinkFile($entity, $file){
        if ($entity) {
            if (file_exists('../public'.$entity->$file)) {
                if ($entity) {
                    if ($entity->$file) {
                        unlink('../public'.$entity->$file);
                    }
                }
            }
        }
    }
}
