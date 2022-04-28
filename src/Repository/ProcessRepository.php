<?php

namespace Gupalo\BpmnWorkflowBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gupalo\BpmnWorkflowBundle\Entity\Process;

class ProcessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Process::class);
    }
    
    public function findByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }

    public function findBySlugs(array $slugs): array
    {
        return $this->findBy(['slug' => $slugs]);
    }
}
