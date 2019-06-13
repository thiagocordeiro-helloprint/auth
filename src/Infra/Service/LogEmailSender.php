<?php declare(strict_types=1);

namespace App\Infra\Service;

use App\AuthService\Email\EmailSender;

class LogEmailSender implements EmailSender
{
    private const TEMPLATE = <<<STRING

    TO: %s
    SUBJECT: %s

%s

STRING;

    public function send(string $to, string $subject, string $message): void
    {
        error_log(
            sprintf(self::TEMPLATE, $to, $subject, $message)
        );
    }
}
