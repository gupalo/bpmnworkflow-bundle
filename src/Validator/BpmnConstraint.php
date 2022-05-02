<?php

namespace Gupalo\BpmnWorkflowBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class BpmnConstraint extends Constraint
{
    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return BpmnValidator::class;
    }
}
