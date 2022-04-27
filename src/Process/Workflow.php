<?php

namespace Gupalo\BpmnWorkflowBundle\Process;

use Gupalo\BpmnWorkflow\Extension\ComparisonInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Traversable;

class Workflow
{
    #[Pure]
    public function __construct(Traversable $extensions)
    {
        $extension = iterator_to_array($extensions);
        $s = 1;
    }
    
}