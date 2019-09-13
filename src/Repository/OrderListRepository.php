<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderList;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderList|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderList|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderList[]    findAll()
 * @method OrderList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderList::class);
    }


    public function findByExampleField($product)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.product = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult();
    }


    public function findListProductInCart($cart, $product)
    {
        return $this->createQueryBuilder('c')
            ->select('count')
            ->innerJoin(Order::class, 'o', 'with', 'c.cart = o.id')
            ->innerJoin(Product::class, 'p', 'with', 'c.product = p.id')
            ->andWhere('c.product = :product')
            ->andWhere('o.cart = :cart')
            ->setParameter('cart', $cart)
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult();
    }

}
