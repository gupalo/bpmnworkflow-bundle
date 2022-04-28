<?php

namespace Gupalo\BpmnWorkflowBundle\Process;

use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Extension\ExtensionHandler;
use Gupalo\BpmnWorkflow\Process\ProcessWalker;
use Gupalo\BpmnWorkflow\Process\Workflow as WorkflowCore;
use Traversable;

class Workflow
{
    private ProcessWalker $processWalker;

    public function __construct(Traversable $extensions)
    {
        $extension = iterator_to_array($extensions);
        $this->processWalker = new ProcessWalker(new ExtensionHandler($extension));
    }

    public function executeProcess(BpmnLoaderInterface $bpmnLoader, ContextInterface $context, string $firstProcessName): void
    {
        $workflow = new WorkflowCore($bpmnLoader, $this->processWalker);
        $workflow->walk($firstProcessName, $context);
    }
}
