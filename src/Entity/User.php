<?php

namespace App\Entity;

use App\Enum\UserStatus;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 50, enumType: UserStatus::class)]
    private UserStatus $status;

    #[ORM\Column(type: 'boolean')]
    private bool $isPremium = false;

    #[ORM\Column(length: 2)]
    private string $countryCode;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $lastActiveAt = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }

    public function isPremium(): bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(bool $isPremium): void
    {
        $this->isPremium = $isPremium;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getLastActiveAt(): ?DateTimeImmutable
    {
        return $this->lastActiveAt;
    }

    public function setLastActiveAt(?DateTimeImmutable $lastActiveAt): void
    {
        $this->lastActiveAt = $lastActiveAt;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
