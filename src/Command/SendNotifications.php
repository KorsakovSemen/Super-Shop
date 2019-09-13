<?php
declare(strict_types=1);


namespace App\Command;


use App\Entity\Check;
use App\EventListener\BoughtEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendNotifications extends Command
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
        parent::__construct();
    }

    protected function configure()
    {

        $this
            ->setName('app:checks:confirmed')
            ->setDescription('Confirmation of an order')
            ->setHelp('This command allows you to send notifications...');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $check = $this->entityManager->getRepository(Check::class)->findNotBought(false);

        foreach ($check as $item) {
            $output->writeln($item->getId());
            $item->setPayed(true);
            $this->entityManager->flush();
            $event = new BoughtEvent($item, 'Sent');
            $this->eventDispatcher->dispatch($event, BoughtEvent::NAME);
            $event->getMessage();

        }

    }
}