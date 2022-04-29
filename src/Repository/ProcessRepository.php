<?php

namespace Gupalo\BpmnWorkflowBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gupalo\BpmnWorkflowBundle\Entity\Process;

class ProcessRepository extends EntityRepository
{
    public function findByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }

    public function findBySlugs(array $slugs): array
    {
        return $this->findBy(['slug' => $slugs]);
    }

    public function create(Process $process): void
    {
        $this->getEntityManager()->persist($process);
        $this->getEntityManager()->flush();
    }

    public function update(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Process $process): void
    {
        $this->getEntityManager()->remove($process);
        $this->getEntityManager()->flush();
    }
}
