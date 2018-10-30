<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Infrastructure\Repositories\PandaUserRepository;

/**
 * Class UserProfileController
 * @package App\Http\Controllers\Auth
 */
class UserProfileController extends Controller
{
    /**
     * Get Profile.
     *
     * @param PandaUserRepository $pandaUserRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PandaUserRepository $pandaUserRepository)
    {
        return view('profile.show', [
            'profile' => $pandaUserRepository->find(auth()->user()->id),
        ]);
    }
}