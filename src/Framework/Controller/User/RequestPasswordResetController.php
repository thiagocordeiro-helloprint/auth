<?php declare(strict_types=1);

namespace App\Framework\Controller\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserPasswordResetService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestPasswordResetController
{
    private UserPasswordResetService $service;

    public function __construct(UserPasswordResetService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $email = $body['email'] ?? '';

        if (!$email) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->service->requestResetPassword($email);
        } catch (UserNotFoundByEmailException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage(), $e);
        }

        return new JsonResponse(['message' => 'Request received']);
    }
}
