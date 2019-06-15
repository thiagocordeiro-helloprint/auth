<?php declare(strict_types=1);

namespace App\Tests\Integration\Endpoint;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserRepository;
use App\Tests\Integration\IntegrationTestCase;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;

class ApiUsersPasswordResetTest extends IntegrationTestCase
{
    private FakeUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new FakeUserRepository();
        $this->setService(UserRepository::class, $this->repository);
    }

    public function testWhenSuccessfullyRequestedThenReturnUserData(): void
    {
        $response = $this->post('api/users/password-reset', ['email' => 'user@localhost']);

        $content = (string) $response->getContent();

        $expected = '{"message":"Request received"}';
        $this->assertEquals($expected, $content);
    }

    public function testWhenUserDoesNotExistThenReturnNotFound(): void
    {
        $this->expectExceptionMessage((new UserNotFoundByEmailException())->getMessage());

        $this->post('api/users/password-reset', ['email' => '123@localhost']);
    }
}
