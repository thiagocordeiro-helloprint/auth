<?php declare(strict_types=1);

namespace App\Controller\User;

use App\AuthService\User\Exception\UserNotFoundByEmailException;
use App\AuthService\User\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FindUserByEmailController
{
    private UserService $repository;

    public function __construct(UserService $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $email): JsonResponse
    {
        try {
            $user = $this->repository->findByEmail($email);
        } catch (UserNotFoundByEmailException $e) {
            throw new HttpException(Response::HTTP_NOT_FOUND, $e->getMessage(), $e);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);
    }
}
