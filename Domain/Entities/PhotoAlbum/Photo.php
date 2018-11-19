<?php

namespace Domain\Entities\PhotoAlbum;

use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Domain\Common\Entity;
use Domain\Services\UploadService;

/**
 * Class Photo
 * @package Domain\Entities\PhotoAlbum
 */
class Photo extends Entity
{
    use Likeable;

    /**
     * @var array
     */
    protected $fillable = ['name', 'album_id', 'description', 'uuid', 'file_name', 'file'];

    /**
     * @param null $size
     * @return string
     * @throws \Exception
     */
    public function getPhoto($size = null)
    {
        $dimensions = (new UploadService())->imageSizes;

        if (isset($size) && !in_array((string)$size, $dimensions, true)) {
            $supportedDimensions = implode(', ', $dimensions);
            throw new \Exception('This dimension ' . $size . ' pixels is not supported. Supported dimensions are: ' . $supportedDimensions . ' pixels in width.');
        }

        return '/storage/uploads/photos/' . ($size . '/' ?? null) . $this->file;
    }

}