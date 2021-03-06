<?php declare(strict_types=1);

namespace App\AuthService\Exception;

use Exception;

class DomainException extends Exception
{
    public function __construct()
    {
        $className = explode('\\', static::class);
        $className = end($className);
        $className = str_replace('Exception', '', $className);

        $message = preg_replace('/(?<!^)([A-Z])/', ' $1', $className);

        parent::__construct($message);
    }
}
