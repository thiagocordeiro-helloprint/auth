<?php declare(strict_types=1);

namespace App\Infra\Service;

use App\AuthService\User\PasswordGenerator;

class RandomBytesPasswordGenerator implements PasswordGenerator
{
    public function random(int $length): string
    {
        return str_replace('=', '', base64_encode(random_bytes(12)));
    }

    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
