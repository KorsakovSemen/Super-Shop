<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class OrderManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrder(User $user, string $status): Order
    {

        $order = new Order();

        $order->setUser($user);
        $order->setStatus($status);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }

    public function set(int $id, string $status)
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $order->setStatus($status);
        $this->entityManager->flush();

    }

    public function remove($id)
    {

        $category = $this->entityManager->getRepository(Order::class)->find($id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();

    }


}