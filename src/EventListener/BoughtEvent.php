<?php
declare(strict_types=1);


namespace App\EventListener;

use Symfony\Contracts\EventDispatcher\Event;

class BoughtEvent extends Event
{
    const NAME = 'ticket_bought';
    private $subject;
    private $message;

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}
