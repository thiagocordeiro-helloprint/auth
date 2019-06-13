<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User\Fake;

use App\AuthService\User\PasswordGenerator;

class FakePasswordGenerator implements PasswordGenerator
{
    public function random(int $length): string
    {
        return 'sVpjm9HS52q3';
    }

    public function hash(string $password): string
    {
        return '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC';
    }
}
