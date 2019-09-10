<?php

namespace App\Doctrine;


use App\Entity\Security\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HashPasswordListener implements EventSubscriber
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof User){
            return;
        }

        $this->encodePassword($entity);

        $entityManager = $args->getEntityManager();
        $meta = $entityManager->getClassMetadata(get_class($entity));
        $entityManager->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }


    //prePersist - called before an entity is originally inserted
    //preUpdate - called before an entity is updated
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param User $entity
     */
    private function encodePassword(User $entity): void
    {
        $plainPassword = $entity->getPlainPassword();

        if(!$plainPassword)
            return;

        $encoded = $this->passwordEncoder->encodePassword($entity, $plainPassword);
        $entity->setPassword($encoded);
    }
}