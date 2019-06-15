<?php declare(strict_types=1);

namespace App\AuthService\User;

use App\AuthService\User\Exception\PasswordMismatchException;
use App\AuthService\User\Exception\UserInactiveException;
use App\AuthService\User\Exception\UserNotFoundByEmailException;

class UserAuthenticationService
{
    private UserLoaderService $userLoader;

    public function __construct(UserLoaderService $userLoader)
    {
        $this->userLoader = $userLoader;
    }

    /**
     * @throws PasswordMismatchException
     * @throws UserInactiveException
     * @throws UserNotFoundByEmailException
     */
    public function authenticate(string $email, $password): User
    {
        $user = $this->userLoader->loadByEmail($email);

        if (!$user->isActive()) {
            throw new UserInactiveException();
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new PasswordMismatchException();
        }

        return $user;
    }
}
