<?php

namespace Gupalo\BpmnWorkflowBundle\Validator;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlLoader;
use Gupalo\BpmnWorkflow\Bpmn\Validator\FacadeValidator;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainerBuilder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Throwable;

class BpmnValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($value) {
            try {
                $xml = (new XmlLoader())->load($value);
                $container = (new XmlSymbolContainerBuilder())->build($xml);
                (new FacadeValidator())->validate($container);
            } catch (Throwable $e) {
                $this->context->buildViolation($e->getMessage())
                    ->addViolation();
            }
        }
    }
}
