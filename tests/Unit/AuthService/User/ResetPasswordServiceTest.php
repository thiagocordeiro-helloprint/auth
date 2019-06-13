<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User;

use App\AuthService\User\Email\PasswordResetEmailService;
use App\AuthService\User\ResetPasswordService;
use App\AuthService\User\User;
use App\Tests\Unit\AuthService\User\Fake\FakeEmailSender;
use App\Tests\Unit\AuthService\User\Fake\FakePasswordGenerator;
use App\Tests\Unit\AuthService\User\Fake\FakeUserRepository;
use PHPUnit\Framework\TestCase;

class ResetPasswordServiceTest extends TestCase
{
    private const USERNAME = 'hellorprint';
    private const EMAIL = 'user@localhost';
    private const PASSWORD = '$2y$10$UffaUPAEJKA03G7YG76vn.fkCESo.wuaSCTYWviLWsgF7AbpPKmNC';
    private const STATUS = 1;

    private const EMAIL_CONTENT = <<<STRING
    TO: user@localhost
    SUBJECT: HelloPrint - Password Reset

    Dear hellorprint,
    Your request to generate a new password was processed successfully, your new password is sVpjm9HS52q3
    
    With kind regards,
    HelloPrint
STRING;


    private FakeUserRepository $repository;
    private FakePasswordGenerator $generator;
    private PasswordResetEmailService $emailService;
    private FakeEmailSender $emailSender;

    protected function setUp(): void
    {
        $this->repository = new FakeUserRepository();
        $this->generator = new FakePasswordGenerator();
        $this->emailSender = new FakeEmailSender();
        $this->emailService = new PasswordResetEmailService($this->emailSender);
    }

    public function testWhenResetInactiveUsersIsCalledThenActiveUserAndCreateANewPassword(): void
    {
        $service = new ResetPasswordService($this->repository, $this->generator, $this->emailService);
        $user = $this->repository->getFakeUser();
        $user->disable();

        $service->resetInactiveUsers();

        $this->assertEquals(new User(self::USERNAME, self::EMAIL, self::STATUS, self::PASSWORD), $user);
    }

    public function testWhenResetInactiveUsersIsCalledThenSendEmailWithNewPassword(): void
    {
        $service = new ResetPasswordService($this->repository, $this->generator, $this->emailService);
        $user = $this->repository->getFakeUser();
        $user->disable();

        $service->resetInactiveUsers();

        $this->assertEquals(
            preg_replace('/\s\s+/', '', self::EMAIL_CONTENT),
            preg_replace('/\s\s+/', '', $this->emailSender->getContent())
        );
    }
}
