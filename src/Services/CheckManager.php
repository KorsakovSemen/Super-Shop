<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\Check;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class CheckManager
{
    private $entityManager;
    private $orderManager;

    public function __construct(EntityManagerInterface $entityManager, OrderManager $orderManager)
    {
        $this->entityManager = $entityManager;
        $this->orderManager = $orderManager;
    }

    public function getTotal(User $user)
    {

        $cart = $this->entityManager->getRepository(Order::class)->findAllUserProducts($user->getId(), Order::STATUS_PENDING);

        $total = 0;

        foreach ($cart->getRows() as $item) {
            if ($item->getProduct()->getTypeSale() != null) {
                $total = $total + ($item->getProduct()->getCost() - $item->getProduct()->getTypeSale()->getMoney()) * ($item->getCount());
            } else {
                $total = $total + $item->getProduct()->getCost() * $item->getCount();
            }
        }

        return $total;
    }

    public function createCheck(Order $cart, bool $payed, int $money): Check
    {

        $check = new Check();

        $check->setCart($cart);
        $check->setMoney($money);
        $check->setPayed($payed);

        $this->entityManager->persist($check);
        $this->entityManager->flush();

        return $check;
    }


    public function remove($id)
    {
        $check = $this->entityManager->getRepository(Check::class)->find($id);

        $this->entityManager->remove($check);
        $this->entityManager->flush();
    }


}