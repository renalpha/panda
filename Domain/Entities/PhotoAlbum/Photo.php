<?php

namespace Domain\Entities\PhotoAlbum;

use Domain\Common\Entity;

/**
 * Class Photo
 * @package Domain\Entities\PhotoAlbum
 */
class Photo extends Entity
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'album_id', 'description', 'uuid', 'file_name', 'file'];

    public function getPhoto($size = null)
    {
        return '/storage/uploads/photos/' . ($size . '/' ?? null) . $this->file;
    }

}