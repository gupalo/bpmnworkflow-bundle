<?php

namespace Gupalo\BpmnWorkflowBundle\Controller;

use Gupalo\BpmnWorkflow\Trace\TraceFileStorage;
use Gupalo\BpmnWorkflowBundle\Entity\Process;
use Gupalo\BpmnWorkflowBundle\Form\ProcessFormType;
use Gupalo\BpmnWorkflowBundle\Repository\ProcessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class TraceHistoryController extends AbstractController
{
    public function __construct(private ProcessRepository $processRepository, private TraceFileStorage $traceFileStorage)
    {
    }

    #[Route(path: '/bpmn/process/trace-history', name: 'bpmn_trace_history', methods: ['GET'])]
    public function traceHistory(): Response
    {
        $traces = $this->traceFileStorage->getTrace();

        return $this->render('@BpmnWorkflow/trace-history.html.twig', [
            'traces' => $traces,
        ]);
    }

    #[Route(path: '/bpmn/process/trace-history-one/{trace}/{process}', name: 'bpmn_trace_history_one', methods: ['GET'])]
    public function traceHistoryPtocess(string $trace, string $process): Response
    {
        $traces = $this->traceFileStorage->getTrace();
        $uids = [];
        foreach ($traces as $key => $data) {
            if ($key === $trace) {
                $uids = $data['trace'][$process] ?? [];
                break;
            }
        }
        
        $processEntity = $this->processRepository->findProcess($process);
        if (!$processEntity || count($uids) === 0) {
            throw new NotFoundHttpException();
        }
        
        return $this->render('@BpmnWorkflow/trace-history-one.html.twig', [
            'uids' => $uids,
            'xml' => $processEntity->getXml()
        ]);
    }
}
