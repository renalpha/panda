<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostAdminPhotoAlbumRequest;
use App\Http\Requests\PostAdminPhotoRequest;
use App\Http\Requests\PostPhotoUploadRequest;
use Domain\Entities\PhotoAlbum\Photo;
use Domain\Entities\PhotoAlbum\PhotoAlbum;
use Domain\Services\PhotoAlbumService;
use Domain\Services\PhotoService;
use Domain\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PhotoAlbumController
 * @package App\Http\Controllers\Admin
 */
class PhotoAlbumController extends Controller
{
    /**
     * @var PhotoService
     */
    protected $photoService;

    /**
     * @var PhotoAlbumService
     */
    protected $albumService;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * PhotoAlbumController constructor.
     *
     * @param UploadService $uploadService
     * @param PhotoService $photoService
     * @param PhotoAlbumService $albumService
     */
    public function __construct(UploadService $uploadService, PhotoService $photoService, PhotoAlbumService $albumService)
    {
        $this->photoService = $photoService;
        $this->albumService = $albumService;
        $this->uploadService = $uploadService;
    }

    /**
     * @param Request $request
     * @param null $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $album = null): View
    {
        return view('admin.photo.index');
    }

    /**
     * @param PostAdminPhotoAlbumRequest $request
     * @param PhotoAlbum|null $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAlbum(PostAdminPhotoAlbumRequest $request, PhotoAlbum $album = null): RedirectResponse
    {
        $this->statusMessage = isset($album->id) && $album->id !== null ? 'Album has successfully been updated!' : 'Album has successfully been created!';

        if ($request->wantsJson() === true) {
            return json_encode(['status' => 'success', 'message' => $this->statusMessage]);
        }

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->route('admin.photoalbum.index');
    }

    /**
     * @param PostAdminPhotoRequest $request
     * @param Photo|null $photo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePhoto(PostAdminPhotoRequest $request, Photo $photo = null): RedirectResponse
    {
        $this->statusMessage = isset($photo->id) && $photo->id !== null ? 'Photo has successfully been updated!' : 'Photo has successfully been created!';

        if ($request->wantsJson() === true) {
            return json_encode(['status' => 'success', 'message' => $this->statusMessage]);
        }

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->route('admin.photoalbum.index');
    }

    /**
     * @param PostPhotoUploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(PostPhotoUploadRequest $request)
    {
        $photos = [];

        foreach ($request->file('files') as $file) {
            $photos[] = $this->uploadService->upload($file, $this->uploadService->uploadPhotoPath);
        }

        return response()
            ->json(['status' => 'success', 'message' => 'Successfully uploaded file.', 'files' => $photos]);
    }
}