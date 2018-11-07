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
     * @throws \Exception
     */
    public function findGroupsByUserId(int $userId)
    {
        try {
            $user = $this->userRepository->where('id', '=', $userId)->first();
            return $user->groups ?? null;
        } catch (\Exception $e) {
            throw new \Exception('Could not find user by id: ' . $userId);
        }
    }
}