<?php declare(strict_types=1);

namespace App\Tests\Integration\Endpoint;

use App\AuthService\User\Exception\UserInactiveException;
use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserRepository;
use App\Tests\Integration\IntegrationTestCase;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;

class ApiUsersLoginTest extends IntegrationTestCase
{
    private FakeUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new FakeUserRepository();
        $this->setService(UserRepository::class, $this->repository);
    }

    public function testWhenSuccessfullyAuthenticatedThenReturnUserData(): void
    {
        $response = $this->post('/api/users/login', ['email' => 'user@localhost', 'password' => 'P@ssw0rd!']);

        $content = (string) $response->getContent();

        $expected = '{"username":"hellorprint","email":"user@localhost","active":true}';
        $this->assertEquals($expected, $content);
    }

    public function testWhenUserIsInactiveThenReturnForbiddenResponse(): void
    {
        $this->repository->getFakeUser()->disable();

        $this->expectExceptionMessage((new UserInactiveException())->getMessage());

        $this->post('/api/users/login', ['email' => 'user@localhost', 'password' => 'P@ssw0rd!']);
    }

    public function testWhenUserDoesNotExistThenReturnNotFound(): void
    {
        $this->expectExceptionMessage((new UserNotFoundByEmailException())->getMessage());

        $this->post('/api/users/login', ['email' => '123@localhost', 'password' => 'P@ssw0rd!']);
    }
}
