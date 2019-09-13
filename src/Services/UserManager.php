<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\MoneyTransaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class UserManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function remove($id)
    {

        $user = $this->entityManager->getRepository(User::class)->find($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

    }

    public function getBalance($user)
    {
        $balance = 0;
        $transactions = $this->entityManager->getRepository(MoneyTransaction::class)->findAllTransactionUser($user);
        foreach ($transactions as $tr) {
            $balance += $tr->getMoney();
        }
        return $balance;
    }


}