<?php declare(strict_types=1);

namespace App\Tests\Unit\AuthService\User\Fake;

use App\AuthService\User\User;
use App\AuthService\User\UserRepository;

class FakeUserRepository implements UserRepository
{
    private const USERNAME = 'hellorprint';
    private const EMAIL = 'user@localhost';
    private const PASSWORD = '$2y$10$9lbpOm1FXp2wbBk6WYfjlu0vfosuHZ693ibnbrUljEeLIz8MdNNZq';
    private const STATUS = 1;

    private User $user;

    public function __construct()
    {
        $this->user = new User(self::USERNAME, self::EMAIL, self::STATUS, self::PASSWORD);
    }

    public function findByEmail(string $email): ?User
    {
        if ($email != self::EMAIL) {
            return null;
        }

        return $this->user;
    }

    public function inactivateUser(User $user): void
    {
        $user->disable();
    }

    public function getFakeUser(): User
    {
        return $this->user;
    }

    /**
     * @return User[]
     */
    public function findInactive(): array
    {
        $this->user->disable();

        return [$this->user];
    }

    public function saveUsers(User ...$users): void
    {
        return;
    }
}
