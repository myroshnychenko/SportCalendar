<?php

namespace WSP\SecondBundle\Service;


use Doctrine\ORM\EntityManager;
use WSP\SecondBundle\Entity\Jam;

class JamDuplicateService
{
    /** @var EntityManager */
    protected $em;


    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    /**
     * Duplicate Jam entities

     * @param Jam $entity
     * @param integer $count
     */
    public function duplicate(Jam $entity, $count = 0)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->em->persist(clone $entity);
        }
        $this->em->flush();
    }
} 