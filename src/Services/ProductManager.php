<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\OrderList;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;


class ProductManager
{
    private $entityManager;
    private $orderManager;

    public function __construct(EntityManagerInterface $entityManager, OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
        $this->entityManager = $entityManager;
    }

    public function createProduct(string $name): Product
    {
        $product = new Product();

        $product->setName($name);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function checkProductInCart($order, OrderList $orderList, int $id)
    {
        foreach ($order->getRows() as $row) {
            if ($row->getProduct()->getId() == $id) {
                $orderList = $row;
            }
        }

        return $orderList;
    }

    public function getProduct($id)
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }


    public function remove($id)
    {

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        $this->entityManager->remove($product);
        $this->entityManager->flush();

    }


}