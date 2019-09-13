<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\MoneyTransaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BalanceManager
{
    private $entityManager;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createTransaction(User $user, int $money): MoneyTransaction
    {

        $transaction = new MoneyTransaction();

        $transaction->setUser($user);
        $transaction->setMoney($money);

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }


    public function remove($id)
    {
        $transaction = $this->entityManager->getRepository(MoneyTransaction::class)->find($id);

        $this->entityManager->remove($transaction);
        $this->entityManager->flush();
    }


}