<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User;

use App\AuthService\User\ResetPasswordService;
use App\AuthService\User\User;
use App\Tests\Unit\AuthService\User\Fake\FakePasswordGenerator;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use PHPUnit\Framework\TestCase;

class ResetPasswordServiceTest extends TestCase
{
    private const USERNAME = 'hellorprint';
    private const EMAIL = 'user@localhost';
    private const PASSWORD = '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC';
    private const STATUS = 1;

    private FakeUserRepository $repository;
    private FakePasswordGenerator $generator;

    protected function setUp(): void
    {
        $this->repository = new FakeUserRepository();
        $this->generator = new FakePasswordGenerator();
    }

    public function testWhenResetInactiveUsersIsCalledThenActiveUserAndCreateANewPassword(): void
    {
        $service = new ResetPasswordService($this->repository, $this->generator);
        $user = $this->repository->getFakeUser();

        $user->disable();
        $service->resetInactiveUsers();

        $this->assertEquals(new User(self::USERNAME, self::EMAIL, self::STATUS, self::PASSWORD), $user);
    }
}
