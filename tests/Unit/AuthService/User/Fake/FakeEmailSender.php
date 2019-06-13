<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User\Fake;

use App\AuthService\Email\EmailSender;

class FakeEmailSender implements EmailSender
{
    private const TEMPLATE = <<<STRING
    TO: %s
    SUBJECT: %s

%s
STRING;

    private string $content;

    public function send(string $to, string $subject, string $message): void
    {
        $this->content = sprintf(self::TEMPLATE, $to, $subject, $message);
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
