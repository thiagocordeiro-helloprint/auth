<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User;

use App\AuthService\User\Exception\PasswordMismatchException;
use App\AuthService\User\Exception\UserInactiveException;
use App\AuthService\User\User;
use App\AuthService\User\UserAuthenticationService;
use App\AuthService\User\UserLoaderService;
use App\AuthService\User\UserRepository;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserAuthenticationServiceTest extends TestCase
{
    private UserRepository $repository;
    private UserLoaderService $userLoader;

    public function setUp(): void
    {
        $this->repository = new FakeUserRepository();
        $this->userLoader = new UserLoaderService($this->repository);
    }

    public function testWhenUserIsNotActiveThenThrowError(): void
    {
        $this->repository->getFakeUser()->disable();
        $service = new UserAuthenticationService($this->userLoader);

        $this->expectException(UserInactiveException::class);

        $service->authenticate('user@localhost', 'P@ssw0rd!');
    }

    public function testWhenGivenPasswordDoesNotMatchThenThrowError(): void
    {
        $service = new UserAuthenticationService($this->userLoader);

        $this->expectException(PasswordMismatchException::class);

        $service->authenticate('user@localhost', '123');
    }

    public function testWhenGivenRightCredentialsThenReturnUser(): void
    {
        $service = new UserAuthenticationService($this->userLoader);

        $user = $service->authenticate('user@localhost', 'P@ssw0rd!');

        $this->assertInstanceOf(User::class, $user);
    }
}
