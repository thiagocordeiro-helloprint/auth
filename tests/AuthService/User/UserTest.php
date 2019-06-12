<?php declare(strict_types=1);

namespace App\Tests\AuthService\User;

use App\AuthService\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testWhenMethodDisableIsCalledThenChangeUserStatusToInactive(): void
    {
        $user = new User('username', 'email', 1, '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC');

        $user->disable();

        $this->assertFalse($user->isActive());
    }

    public function testWhenMethodEnableIsCalledThenChangeUserStatusToActive(): void
    {
        $user = new User('username', 'email', 0, '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC');

        $user->enable();

        $this->assertTrue($user->isActive());
    }
}
