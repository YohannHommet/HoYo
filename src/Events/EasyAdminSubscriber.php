<?php

namespace App\Events;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class EasyAdminSubscriber implements EventSubscriberInterface
{

    private UserPasswordEncoderInterface $encoder;
    private SluggerInterface $slugger;


    public function __construct(UserPasswordEncoderInterface $encoder, SluggerInterface $slugger)
    {
        $this->encoder = $encoder;
        $this->slugger = $slugger;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setPassword'],
            BeforeEntityUpdatedEvent::class => ['updatePassword'], ['updateArticle'],
        ];
    }


    private function hashPassword($event): void
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof User)) {
            return;
        }
        $entity->setPassword($this->encoder->encodePassword($entity, $entity->getPassword()));

    }


    public function setPassword(BeforeEntityPersistedEvent $event): void
    {
        $this->hashPassword($event);
    }


    public function updatePassword(BeforeEntityUpdatedEvent $event): void
    {
        $this->hashPassword($event);
    }


    public function updateArticle(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Category) {
            /** @Var \App\Entity\Category|$entity */
            $entity->setSlug($this->slugger->slug($entity->getName()));
        }
        if ($entity instanceof Article) {
            /** @Var \App\Entity\Article|$entity */
            $entity->setSlug($this->slugger->slug($entity->getTitle()));
        }
    }

}