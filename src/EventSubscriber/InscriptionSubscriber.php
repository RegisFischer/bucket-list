<?php

namespace App\EventSubscriber;

use App\Event\InscriptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class InscriptionSubscriber implements EventSubscriberInterface
{
    private $mailer;
    public function __construct(MailerInterface  $mailer)
    {
        $this->mailer=$mailer;
    }

    public function onKernelRequest(InscriptionEvent  $event)
    {

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
        dd("mailer");

    }

    public static function getSubscribedEvents()
    {
        return [
            InscriptionEvent::NAME => 'onKernelRequest',
        ];
    }
}
