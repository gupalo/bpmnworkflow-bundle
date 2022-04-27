<?php

namespace Gupalo\BpmnWorkflowBundle\Extension;

use Gupalo\BpmnWorkflow\Extension\ComparisonInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Examples: ("contains", "in", ">=", "<=", ">", "<", "not in", "==", "not contains", "!=")
 *  - some_function() contains "visa"
 *  - some_function() in ["visa", "masterCard"]
 *  - some_function() >=10
 *  - some_function() >10
 *  - some_function() <=100
 *  - some_function() <100
 *  - some_function() not in ["visa", "masterCard"]
 *  - some_function() ==true
 *  - some_function() not contains "visa"
 *  - some_function() ==10
 *  - some_function() !=10
 */
class ExpressionLanguageComparison implements ComparisonInterface
{
    public function execute($functionResult, string $condition): bool
    {
        $expression = $this->prepareExpression($functionResult, $condition);

        $expressionLanguage = new ExpressionLanguage();

        return $expressionLanguage->evaluate($expression, ['var' => $functionResult]);
    }

    public function match(string $identity): bool
    {
        $identity = trim($identity);
        if (
            !str_starts_with($condition, '!=') &&
            !str_starts_with($condition, 'contains ') &&
            !str_starts_with($condition, 'not contains ') &&
            !str_starts_with($condition, 'in ') &&
            !str_starts_with($condition, 'not in ') &&
            !str_starts_with($condition, '>') &&
            !str_starts_with($condition, '>=') &&
            !str_starts_with($condition, '<') &&
            !str_starts_with($condition, '<=') &&
            !str_starts_with($condition, '==')
        ) {
            return false;
        }
    }

    private function prepareExpression($argument, string $condition): string
    {
        $condition = trim($condition);

        $expression = 'var ' . $condition;

        if (str_starts_with($condition, 'contains ') || str_starts_with($condition, 'not contains ')) {
            if (!is_array($argument)) {
                throw new SyntaxError('function result must be array when condition contains');
            }
        }

        if (is_array($argument) && str_starts_with($condition, 'contains ')) {
            $expression = trim(str_replace('contains', '', $condition)) . ' in var';
        }

        if (is_array($argument) && str_starts_with($condition, 'not contains ')) {
            $expression = trim(str_replace('not contains', '', $condition)) . ' not in var';
        }

        return $expression;
    }
}
