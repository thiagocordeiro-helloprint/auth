<?php declare(strict_types=1);

namespace App\AuthService\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;

class UserLoaderService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws UserNotFoundByEmailException
     */
    public function loadByEmail(string $email): User
    {
        $user = $this->repository->findByEmail($email);

        if (!$user) {
            throw new UserNotFoundByEmailException();
        }

        return $user;
    }
}
