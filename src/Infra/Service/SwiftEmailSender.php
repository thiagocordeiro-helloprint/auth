<?php declare(strict_types=1);

namespace App\Infra\Service;

use App\AuthService\Email\EmailSender;
use Swift_Mailer;
use Swift_Message;

class SwiftEmailSender implements EmailSender
{
    private Swift_Mailer $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $to, string $subject, string $message): void
    {
        $message = (new Swift_Message($subject))
            ->setFrom('helloprint@localhost')
            ->setTo($to)
            ->setBody($message, 'text/plain');

        $this->mailer->send($message);
    }
}
