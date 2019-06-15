<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User;

use App\AuthService\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testWhenMethodDisableIsCalledThenChangeUserStatusToInactive(): void
    {
        $user = new User('username', 'email', 1, '123');

        $user->disable();

        $this->assertFalse($user->isActive());
    }

    public function testWhenMethodEnableIsCalledThenChangeUserStatusToActive(): void
    {
        $user = new User('username', 'email', 0, '123');

        $user->enable();

        $this->assertTrue($user->isActive());
    }
}
