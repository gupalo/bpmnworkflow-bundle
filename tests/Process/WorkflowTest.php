<?php

namespace Gupalo\BpmmWorkflowBundle\Tests\Extension;

use Gupalo\BpmmWorkflowBundle\Tests\Example\Cart\Cart;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnDirLoader;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflowBundle\Process\Workflow;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkflowTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testWalkFlow(): void
    {
        $cart = new Cart(
            items: ['name' => 'cola', 'price' => 800],
            locale: 'en',
            price: 800,
        );
        $context = new DataContext($cart);

        /** @var Workflow $workflow */
        $workflow = self::getContainer()->get(Workflow::class);
        
        $workflow->executeProcess((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $context, 'cart_discount');

        self::assertEquals(360, $cart->getPrice());
    }

    public function testWalkFlow_BigPrice(): void
    {
        $cart = new Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        
        /** @var Workflow $workflow */
        $workflow = self::getContainer()->get(Workflow::class);

        $workflow->executeProcess((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $context, 'cart_discount');

        self::assertEquals(2000, $cart->getPrice());
    }
}
