<?php

namespace App\Infra\Repository;

use App\AuthService\User\User;
use App\AuthService\User\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function inactivateUser(User $user): void
    {
        $entityManager = $this->getEntityManager();

        $user->disable();

        $entityManager->persist($user);
        $entityManager->flush();
    }

    /**
     * @return User[]
     */
    public function findInactive(): array
    {
        return $this->findBy(['status' => 0]);
    }

    public function saveUsers(User ...$users): void
    {
        $entityManager = $this->getEntityManager();

        foreach ($users as $user) {
            $entityManager->persist($user);
        }

        $entityManager->flush();
    }
}
