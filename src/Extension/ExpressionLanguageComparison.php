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
    public function execute(mixed $functionResult, string $condition): bool
    {
        $expression = $this->prepareExpression($functionResult, $condition);

        return (new ExpressionLanguage())->evaluate($expression, ['var' => $functionResult]);
    }

    public function match(string $identity): bool
    {
        return preg_match('#^(!=|<|<=|>|>=|==|contains |not contains |in |not in )#', trim($identity));
    }

    private function prepareExpression($argument, string $condition): string
    {
        $condition = trim($condition);

        $expression = 'var ' . $condition;

        if (!is_array($argument) && preg_match('#^(contains|not contains) #', $condition)) {
            throw new SyntaxError('function result must be array when condition contains');
        }

        if (is_array($argument)) {
            if (str_starts_with($condition, 'contains ')) {
                $expression = sprintf('%s in var', trim(preg_replace('#^contains#', '', $condition)));
            }
            if (str_starts_with($condition, 'not contains ')) {
                $expression = sprintf('%s not in var', trim(preg_replace('#^not contains#', '', $condition)));
            }
        }

        return $expression;
    }
}
