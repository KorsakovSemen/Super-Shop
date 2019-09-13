<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\Order;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Templating\EngineInterface;

class Mailer
{

    private $swiftMailer;
    private $twig;


    public function __construct(Swift_Mailer $mailer, EngineInterface $twig)
    {
        $this->twig = $twig;
        $this->swiftMailer = $mailer;
    }

    public function sendMail(Order $cart, int $total, string $mail, string $userName)
    {

        $message = (new Swift_Message('Purchased completed'))
            ->setFrom('send@example.com')
            ->setTo($mail)
            ->setBody($this->twig->render('catalog/message.html.twig', [
                'cart' => $cart,
                'total' => $total,
                'user' => $userName]), 'text/html');
        $this->swiftMailer->send($message);

    }
}