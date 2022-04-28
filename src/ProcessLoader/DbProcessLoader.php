<?php

namespace Gupalo\BpmnWorkflowBundle\ProcessLoader;

use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflowBundle\Entity\Process;
use Gupalo\BpmnWorkflowBundle\Repository\ProcessRepository;

class DbProcessLoader implements BpmnLoaderInterface
{
    private array $slugs = [];
    private array $ids = [];

    public function __construct(private readonly ProcessRepository $processRepository)
    {
    }

    public function load(): array
    {
        $proceses = $this->findProcesses();

        $result = [];
        foreach ($proceses as $process) {
            $result[$process->getSlug()] = $process->getXml();
        }

        return $result;
    }

    public function setSlugs(array $slugs): void
    {
        $this->slugs = $slugs;
    }

    public function setIds(array $ids): void
    {
        $this->ids = $ids;
    }

    /** @return Process[] */
    private function findProcesses(): array
    {
        if ($this->slugs) {
            $proceses = $this->processRepository->findBySlugs($this->slugs);
        } elseif ($this->ids) {
            $proceses = $this->processRepository->findByIds($this->ids);
        } else {
            $proceses = $this->processRepository->findAll();
        }

        return $proceses;
    }
}
