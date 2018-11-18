<?php

namespace Domain\Services;

use Illuminate\Support\Str;
use Infrastructure\Repositories\PhotoAlbumRepository;

/**
 * Class PhotoAlbumService
 * @package Domain\Services
 */
class PhotoAlbumService extends AbstractService
{
    /**
     * PhotoAlbumService constructor.
     * @param PhotoAlbumRepository $repository
     */
    public function __construct(PhotoAlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->repository->whereNull('parent_id')->get();
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return mixed
     */
    public function saveAlbum(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->update($id, $params);
        } else {
            $params['uuid'] = Str::uuid();
            return $this->create($params);
        }
    }
}