<?php

namespace Innonic\JobBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class JobManager
 */
class JobManager
{
    private $em;

    /**
     * AuthorManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findByKeyWord($keyword)
    {
        $qb = $this->getQueryBuilder();

        $qb->select('j')->from('Innonic\JobBundle\Entity\Job', 'n')
            ->where( $qb->expr()->like('j.location', $qb->expr()->literal('%' . $keyword . '%')) )
            ->orWhere( $qb->expr()->like('j.position', $qb->expr()->literal('%' . $keyword . '%')) )
            ->orWhere( $qb->expr()->like('j.company', $qb->expr()->literal('%' . $keyword . '%')) );

        return $qb->getQuery()->getResult();
    }

    private function getQueryBuilder(){
        $qb = $this->em->getRepository('JobBundle:Job')
            ->createQueryBuilder('j');

        return $qb;
    }
}