<?php

namespace Gupalo\BpmnWorkflowBundle\Controller;

use Gupalo\BpmnWorkflowBundle\Entity\Process;
use Gupalo\BpmnWorkflowBundle\Form\ProcessFormType;
use Gupalo\BpmnWorkflowBundle\Repository\ProcessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcessController extends AbstractController
{
    public function __construct(private ProcessRepository $processRepository)
    {
    }

    #[Route(path: '/bpmn/process/lists', name: 'bpmn_process_lists', methods: ['GET'])]
    public function lists(): Response
    {
        return $this->render('@BpmnWorkflow/lists.html.twig', [
            'items' => $this->processRepository->findAll()
        ]);
    }

    #[Route(path: '/bpmn/process/delete/{id}', name: 'bpmn_process_delete', methods: ['GET'])]
    public function delete(Process $process): Response
    {
        $this->processRepository->remove($process);
        
        return $this->redirectToRoute('bpmn_process_lists');
    }

    #[Route(path: '/bpmn/process/create', name: 'bpmn_process_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $process = new Process();
        $form = $this->createForm(ProcessFormType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->processRepository->create($process);

            return $this->redirectToRoute('bpmn_process_lists');
        }

        return $this->render('@BpmnWorkflow/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $process
        ]);
    }

    #[Route(path: '/bpmn/process/edit/{id}', name: 'bpmn_process_edit', methods: ['GET', 'POST'])]
    public function edit(Process $process, Request $request): Response
    {
        $form = $this->createForm(ProcessFormType::class, $process);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->processRepository->update();

            return $this->redirectToRoute('bpmn_process_lists');
        }

        return $this->render('@BpmnWorkflow/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $process
        ]);
    }
}
