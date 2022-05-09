<?php

namespace Gupalo\BpmnWorkflowBundle\Tests\Example\Extension;

use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Extension\FunctionInterface;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Cart\Cart;

class PriceFunction implements FunctionInterface
{
    public function execute(array $params, ContextInterface $context): string
    {
        /** @var Cart $cart */
        $cart = $context->getData();

        return (string)$cart->getPrice();
    }
}
