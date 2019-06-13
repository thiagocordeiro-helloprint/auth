<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\Service;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\User;
use App\AuthService\User\UserRepository;
use App\AuthService\User\UserService;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private const USERNAME = 'hellorprint';
    private const EMAIL = 'user@localhost';
    private const PASSWORD = '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC';
    private const STATUS = 1;

    private UserRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new FakeUserRepository();
    }

    public function testWhenUserIsNotFoundThenThrowError(): void
    {
        $service = new UserService($this->repository);

        $this->expectException(UserNotFoundByEmailException::class);

        $service->findByEmail('no-reply@localhost');
    }

    public function testWhenUserIsFoundThenShouldNotThrowException(): void
    {
        $service = new UserService($this->repository);
        $user = new User(self::USERNAME, self::EMAIL, self::STATUS, self::PASSWORD);

        $response = $service->findByEmail('user@localhost');

        $this->assertEquals($user, $response);
    }

    public function testWhenPasswordResetIsRequestedThenInactivateUser(): void
    {
        $service = new UserService($this->repository);

        $service->requestResetPassword('user@localhost');

        $user = $this->repository->getFakeUser();
        $this->assertFalse($user->isActive());
    }
}
