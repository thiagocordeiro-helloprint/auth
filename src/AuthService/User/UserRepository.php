<?php declare(strict_types=1);

namespace App\AuthService\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;

    public function inactivateUser(User $user): void;

    /**
     * @return User[]
     */
    public function findInactive(): array;

    public function saveUsers(User ...$users): void;
}
