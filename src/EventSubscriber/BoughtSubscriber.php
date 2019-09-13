<?php
declare(strict_types=1);


namespace App\EventSubscriber;

use App\EventListener\BoughtEvent;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Templating\EngineInterface;

class BoughtSubscriber implements EventSubscriberInterface
{
    private $swiftMailer;


    public function __construct(Swift_Mailer $mailer)
    {
        $this->swiftMailer = $mailer;
    }

    public function onTicketBought()
    {
        $message = (new Swift_Message('Заказ выслан'))
            ->setFrom('send@example.com')
            ->setTo('deacle2009@mail.ru')
            ->setBody('Ваш заказ выслан
                       
Спасибо за покупку!');
        $this->swiftMailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return array(
            BoughtEvent::NAME => 'onTicketBought'
        );
    }
}
