<?php

namespace Domain\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadService
 * @package Domain\Services
 */
class UploadService extends AbstractService
{
    /**
     * @var
     */
    public $uploadPhotoPath;

    /**
     * UploadService constructor.
     */
    public function __construct()
    {
        $uploadPaths = [];

        $this->uploadPhotoPath = config('panda.photo_uploads', 'uploads/photos');
        $uploadPaths[] = $this->uploadPhotoPath;

        $this->checkExistingFolders($uploadPaths);
    }

    /**
     * Upload file.
     *
     * @param $file
     * @param $path
     * @return \stdClass
     */
    public function upload($file, $path): \stdClass
    {
        $filename = $file->store($path);

        $uploadObject = new \stdClass();
        $uploadObject->name = str_replace($path, '', $file->getClientOriginalName());
        $uploadObject->size = round(Storage::size($filename) / 1024, 2);

        return $uploadObject;
    }

    /**
     * Check if paths exists and create if non existing.
     *
     * @param array $paths
     */
    protected function checkExistingFolders(array $paths): void
    {
        foreach ($paths as $path) {
            if (File::exists($path) !== true) {
                File::makeDirectory($path, 755, true);
            }
        }
    }
}