<?php

namespace Domain\Services;

use Infrastructure\Repositories\PandaUserRepository;

/**
 * Class PandaUserService
 *
 * @package Domain\Services
 */
class PandaUserService
{
    /**
     * @var PandaUserRepository
     */
    protected $userRepository;

    /**
     * PandaUserService constructor.
     * @param PandaUserRepository $userRepository
     */
    public function __construct(PandaUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function findGroupsByUserId(int $userId)
    {
        $user = $this->userRepository->where('id', '=', $userId)->firstOrFail();
        return $user->groups;
    }
}