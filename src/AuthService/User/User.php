<?php declare(strict_types=1);

namespace App\AuthService\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string") */
    private string $username;

    /** @ORM\Column(type="string") */
    private string $email;

    /** @ORM\Column(type="integer") */
    private int $status;

    /** @ORM\Column(type="string") */
    private string $password;

    public function __construct(string $username, string $email, int $active, string $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->status = $active;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function isActive(): bool
    {
        return $this->status == 1;
    }

    public function disable()
    {
        $this->status = 0;
    }

    public function enable()
    {
        $this->status = 1;
    }

    public function resetPassword(string $newPassword)
    {
        $this->password = $newPassword;
    }
}
