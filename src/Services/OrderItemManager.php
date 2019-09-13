<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\OrderList;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;


class OrderItemManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrderList(Product $product, $order, int $count): OrderList
    {

        $orderList = new OrderList();

        $orderList->setProduct($product);
        $orderList->setCart($order);
        $orderList->setCount($count);

        $this->entityManager->persist($orderList);
        $this->entityManager->flush();

        return $orderList;
    }


    public function remove($id)
    {

        $category = $this->entityManager->getRepository(OrderList::class)->find($id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();

    }


}