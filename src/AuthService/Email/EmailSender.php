<?php

namespace App\AuthService\Email;

interface EmailSender
{
    public function send(string $to, string $subject, string $message): void;
}
