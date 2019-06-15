<?php declare(strict_types=1);

namespace App\AuthService\User\Exception;

use App\AuthService\Exception\DomainException;

class PasswordMismatchException extends DomainException
{
}
