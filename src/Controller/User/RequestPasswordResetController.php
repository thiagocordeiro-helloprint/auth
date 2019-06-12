<?php declare(strict_types=1);

namespace App\Controller\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestPasswordResetController
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(string $email)
    {
        try {
            $this->service->requestResetPassword($email);
        } catch (UserNotFoundByEmailException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage(), $e);
        }

        return new Response();
    }
}
