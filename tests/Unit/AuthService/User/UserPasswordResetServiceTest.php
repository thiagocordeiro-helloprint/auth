<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\Service;

use App\AuthService\User\UserLoaderService;
use App\AuthService\User\UserPasswordResetService;
use App\AuthService\User\UserRepository;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use PHPUnit\Framework\TestCase;

class UserPasswordResetServiceTest extends TestCase
{
    private UserRepository $repository;
    private UserLoaderService $userLoader;

    protected function setUp(): void
    {
        $this->repository = new FakeUserRepository();
        $this->userLoader = new UserLoaderService($this->repository);
    }

    public function testWhenPasswordResetIsRequestedThenInactivateUser(): void
    {
        $service = new UserPasswordResetService($this->userLoader, $this->repository);

        $service->requestResetPassword('user@localhost');

        $user = $this->repository->getFakeUser();
        $this->assertFalse($user->isActive());
    }
}
