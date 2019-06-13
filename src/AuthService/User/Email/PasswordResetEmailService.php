<?php declare(strict_types=1);

namespace App\AuthService\User\Email;

use App\AuthService\Email\EmailSender;
use App\AuthService\User\User;

class PasswordResetEmailService
{
    const MESSAGE = <<<HTML
    Dear %s,
    
    Your request to generate a new password was processed successfully, your new password is %s
    
    With kind regards,
    HelloPrint
HTML;

    private EmailSender $emailSender;

    public function __construct(EmailSender $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    public function send(User $user, string $newPassword): void
    {
        $this->emailSender->send(
            $user->getEmail(),
            'HelloPrint - Password Reset',
            sprintf(self::MESSAGE, $user->getUsername(), $newPassword)
        );
    }
}
