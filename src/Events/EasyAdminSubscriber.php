<?php


namespace App\Events;


use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setPassword'],
            BeforeEntityUpdatedEvent::class => ['updatePassword']
        ];
    }


    public function setPassword(BeforeEntityPersistedEvent $event): void
    {
        $this->hashPassword($event);
    }


    private function hashPassword($event): void
    {
        /** @var \App\Entity\User|$user */
        $user = $event->getEntityInstance();
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
    }


    public function updatePassword(BeforeEntityUpdatedEvent $event): void
    {
        $this->hashPassword($event);
    }

}