<?php declare(strict_types=1);

namespace App\AuthService\User;

interface PasswordGenerator
{
    public function random(int $length): string;

    public function hash(string $password): string;
}
