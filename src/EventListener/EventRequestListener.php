<?php

namespace App\EventListener;

use App\Entity\EventRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: Events::prePersist, entity: EventRequest::class)]
class EventRequestListener
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function prePersist(EventRequest $request, LifecycleEventArgs $event): void
    {
        if (null !== $request->getRequestedBy()) {
            return;
        }

        $user = $this->security->getUser();
        if ($user instanceof User) {
            $request->setRequestedBy($user);
        }
    }
}
