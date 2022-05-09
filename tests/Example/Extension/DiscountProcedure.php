<?php

namespace Gupalo\BpmnWorkflowBundle\Tests\Example\Extension;

use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Extension\ProcedureInterface;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Cart\Cart;

class DiscountProcedure implements ProcedureInterface
{
    public function execute(array $params, ContextInterface $context): void
    {
        /** @var Cart $cart */
        $cart = $context->getData();

        $cart->setPrice($cart->getPrice()*((100-$params[0])/100));
    }
}
