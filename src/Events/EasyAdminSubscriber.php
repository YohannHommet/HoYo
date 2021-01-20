<?php


namespace App\Events;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class EasyAdminSubscriber implements EventSubscriberInterface
{

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


    private function hashPassword($event): void
    {
        /** @var \App\Entity\User|$user */
        $entity = $event->getEntityInstance();
        if ($entity instanceof User) {
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        }

    }


    public function setPassword(BeforeEntityPersistedEvent $event): void
    {
        $this->hashPassword($event);
    }


    public function updatePassword(BeforeEntityUpdatedEvent $event): void
    {
        $this->hashPassword($event);
    }

}