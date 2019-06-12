<?php declare(strict_types=1);

namespace App\AuthService\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;

class UserService
{
    private UserRepository $repository;

    public function __construct(UserRepository $userLoader)
    {
        $this->repository = $userLoader;
    }

    public function findByEmail(string $email): User
    {
        $user = $this->repository->findByEmail($email);

        if (!$user) {
            throw new UserNotFoundByEmailException();
        }

        return $user;
    }
}
