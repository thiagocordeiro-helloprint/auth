<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\User;
use App\AuthService\User\UserLoaderService;
use App\AuthService\User\UserRepository;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserLoaderServiceTest extends TestCase
{
    private const USERNAME = 'hellorprint';
    private const EMAIL = 'user@localhost';
    private const PASSWORD = '$2y$10$9lbpOm1FXp2wbBk6WYfjlu0vfosuHZ693ibnbrUljEeLIz8MdNNZq';
    private const STATUS = 1;

    private UserRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new FakeUserRepository();
    }

    public function testWhenUserIsNotFoundThenThrowError(): void
    {
        $service = new UserLoaderService($this->repository);

        $this->expectException(UserNotFoundByEmailException::class);

        $service->loadByEmail('no-reply@localhost');
    }

    public function testWhenUserIsFoundThenShouldNotThrowException(): void
    {
        $service = new UserLoaderService($this->repository);
        $user = new User(self::USERNAME, self::EMAIL, self::STATUS, self::PASSWORD);

        $response = $service->loadByEmail('user@localhost');

        $this->assertEquals($user, $response);
    }
}
