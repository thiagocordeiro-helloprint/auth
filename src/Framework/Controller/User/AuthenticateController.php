<?php declare(strict_types=1);

namespace App\Framework\Controller\User;

use App\AuthService\User\Exception\PasswordMismatchException;
use App\AuthService\User\Exception\UserInactiveException;
use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserAuthenticationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthenticateController
{
    private UserAuthenticationService $service;

    public function __construct(UserAuthenticationService $repository)
    {
        $this->service = $repository;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $email = $body['email'] ?? '';
        $password = $body['password'] ?? '';

        if (!$email || !$password) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->service->authenticate($email, $password);
        } catch (PasswordMismatchException $e) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, $e->getMessage(), $e);
        } catch (UserInactiveException $e) {
            throw new HttpException(Response::HTTP_FORBIDDEN, $e->getMessage(), $e);
        } catch (UserNotFoundByEmailException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage(), $e);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'active' => $user->isActive(),
        ]);
    }
}
