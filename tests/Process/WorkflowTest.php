<?php

namespace Gupalo\BpmmWorkflowBundle\Tests\Extension;

use Gupalo\BpmmWorkflowBundle\Tests\Example\Cart\Cart;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnDirLoader;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflowBundle\Process\Workflow;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkflowTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @dataProvider contexts
     */
    public function testFlow(ContextInterface $context, int $result): void
    {
        /** @var Workflow $workflow */
        $workflow = self::getContainer()->get(Workflow::class);

        $workflow->executeProcess((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $context, 'cart_discount');

        self::assertEquals($result, $context->getData()->getPrice());
    }

    public function contexts(): iterable
    {
        yield 'cart small price' => [
            new DataContext(new Cart(
                items: ['name' => 'cola', 'price' => 800],
                locale: 'en',
                price: 800,
            )),
            360
        ];

        yield 'cart big price' => [
            new DataContext(new Cart(
                items: ['name' => 'cola', 'price' => 5000],
                locale: 'en',
                price: 5000,
            )),
            2000
        ];
    }
}
