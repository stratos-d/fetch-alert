<?php

namespace App\Entity;

use App\Enum\DeviceType;
use App\Repository\DeviceRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'devices')]
#[ORM\Index(name: 'idx_devices_user_type', fields: ['user', 'type'])]
#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(name: 'platform', length: 50, enumType: DeviceType::class)]
    private DeviceType $type;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getType(): DeviceType
    {
        return $this->type;
    }

    public function setType(DeviceType $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
