<?php declare(strict_types=1);

namespace App\Tests\AuthService\Service;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\User;
use App\AuthService\User\UserService;
use App\Tests\AuthService\User\Fake\FakeUserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $service;

    protected function setUp(): void
    {
        $this->service = new UserService(new FakeUserRepository());
    }

    public function testWhenUserIsNotFoundThenThrowError(): void
    {
        $this->expectException(UserNotFoundByEmailException::class);

        $this->service->findByEmail('no-reply@localhost');
    }

    public function testWhenUserIsFoundThenShouldNotThrowException(): void
    {
        $user = new User('123-abc', 'user@localhost');

        $response = $this->service->findByEmail('user@localhost');

        $this->assertEquals($user, $response);
    }
}
