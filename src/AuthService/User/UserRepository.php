<?php declare(strict_types=1);

namespace App\AuthService\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
}
