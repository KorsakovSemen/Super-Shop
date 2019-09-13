<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\MoneyTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MoneyTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyTransaction[]    findAll()
 * @method MoneyTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyTransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MoneyTransaction::class);
    }


    public function findAllTransactionUser($id)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


}
