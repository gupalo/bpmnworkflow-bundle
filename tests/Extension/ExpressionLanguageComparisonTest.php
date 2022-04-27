<?php

namespace Gupalo\BpmmWorkflowBundle\Tests\Extension;

use Gupalo\BpmnWorkflowBundle\Extension\ExpressionLanguageComparison;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionLanguageComparisonTest extends TestCase
{
    /**
     * @dataProvider condition
     */
    public function testExpression(
        string $condition,
        $functionResult,
        bool $expressionResult
    ): void
    {
        self::assertEquals($expressionResult, (new ExpressionLanguageComparison())->execute($functionResult, $condition));
    }

    public function condition(): iterable
    {
        yield 'contains true' => ['contains "aaa"', ['aaa', 'bbb'], true];

        yield 'contains false' => ['contains "aaa"', ['ccc', 'bbb'], false];

        yield 'not contains false' => ['not contains "aaa"', ['aaa', 'bbb'], false];

        yield 'not contains true' => ['not contains "aaa"', ['ccc', 'bbb'], true];

        yield 'in true' => ['in ["aaa", "bbb"]', 'aaa', true];

        yield 'in false' => ['in ["ccc", "bbb"]', 'aaa', false];

        yield 'not in false' => ['not in ["aaa", "bbb"]', 'aaa', false];

        yield 'not in true' => ['not in ["ccc", "bbb"]', 'aaa', true];

        yield '= true' => [' == 10', '10', true];

        yield '= int true' => [' == 10', 10, true];

        yield '= bool true' => [' == true', true, true];
        
        yield '!= bool true' => [' != true', true, false];

        yield '!= false' => [' != 10', '10', false];

        yield '>= true' => [' >=10', '20', true];
        
        yield '> true' => [' >10', '20', true];

        yield '<= false' => [' >=10', '5', false];
        
        yield '< false' => [' >10', '5', false];
    }
}
