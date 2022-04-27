<?php

namespace Gupalo\BpmmWorkflowBundle\Tests\Extension;

use Gupalo\BpmnWorkflowBundle\Process\Workflow;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkflowTest extends KernelTestCase
{
    public function testTest(): void
    {
        self::bootKernel();
        $ee = self::$kernel->getContainer()->get(Workflow::class);
    }
}
