<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\TypeNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeNotification[]    findAll()
 * @method TypeNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeNotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeNotification::class);
    }


}
