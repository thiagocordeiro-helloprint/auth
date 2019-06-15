<?php declare(strict_types=1);

namespace App\AuthService\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;

class UserPasswordResetService
{
    private UserLoaderService $userLoader;
    private UserRepository $repository;

    public function __construct(UserLoaderService $userLoader, UserRepository $repository)
    {
        $this->userLoader = $userLoader;
        $this->repository = $repository;
    }

    /**
     * @throws UserNotFoundByEmailException
     */
    public function requestResetPassword(string $email): void
    {
        $user = $this->userLoader->loadByEmail($email);

        $this->repository->inactivateUser($user);
    }
}
