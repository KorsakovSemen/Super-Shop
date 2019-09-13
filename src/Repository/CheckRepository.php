<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Check;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Check|null find($id, $lockMode = null, $lockVersion = null)
 * @method Check|null findOneBy(array $criteria, array $orderBy = null)
 * @method Check[]    findAll()
 * @method Check[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Check::class);
    }

    public function findByExampleField($id)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin(Order::class, 'o', 'with', 'c.cart = o.id')
            ->andWhere('o.user = :id')
            ->setParameter('id', $id)
            ->orderBy('c.payed', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNotBought($payed)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.payed = :payed')
            ->setParameter('payed', $payed)
            ->getQuery()
            ->getResult();
    }


}
