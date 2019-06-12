<?php declare(strict_types=1);

namespace App\Tests\AuthService\User\Fake;

use App\AuthService\User\User;
use App\AuthService\User\UserRepository;

class FakeUserRepository implements UserRepository
{
    private const ID = '123-abc';
    private const EMAIL = 'user@localhost';

    public function findByEmail(string $email): ?User
    {
        if ($email != self::EMAIL) {
            return null;
        }

        return new User(self::ID, self::EMAIL);
    }
}
