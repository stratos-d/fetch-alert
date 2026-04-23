<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\User;
use App\Enum\DeviceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Device>
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function userHasDeviceType(User $user, DeviceType $type): bool
    {
        $count = $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->andWhere('d.user = :user')
            ->andWhere('d.type = :type')
            ->setParameter('user', $user)
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $count > 0;
    }
}
