<?php declare(strict_types=1);

namespace App\AuthService\User;

use App\AuthService\User\Email\PasswordResetEmailService;

class ResetPasswordService
{
    private UserRepository $repository;
    private PasswordGenerator $passwordGenerator;
    private PasswordResetEmailService $emailService;

    public function __construct(
        UserRepository $repository,
        PasswordGenerator $passwordGenerator,
        PasswordResetEmailService $emailService
    ) {
        $this->repository = $repository;
        $this->passwordGenerator = $passwordGenerator;
        $this->emailService = $emailService;
    }

    public function resetInactiveUsers()
    {
        $users = $this->repository->findInactive();

        foreach ($users as $user) {
            $rawPassword = $this->passwordGenerator->random(12);

            $this->resetUserPassword($rawPassword, $user);
            $this->sendNewPasswordViaEmail($rawPassword, $user);
        }

        $this->repository->saveUsers(...$users);
    }

    private function resetUserPassword(string $rawPassword, User $user): void
    {
        $password = $this->passwordGenerator->hash($rawPassword);
        $user->resetPassword($password);
        $user->enable();
    }

    private function sendNewPasswordViaEmail(string $rawPassword, User $user): void
    {
        // ...
    }
}
