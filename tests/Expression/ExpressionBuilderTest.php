<?php

namespace PETest\Component\Query\Expression;

use PE\Component\Query\Expression\ComparisonExpression;
use PE\Component\Query\Expression\CompositeExpression;
use PE\Component\Query\Expression\ExpressionBuilder;
use PE\Component\Query\Expression\ValueExpression;

class ExpressionBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testAndX()
    {
        $builder = new ExpressionBuilder();

        $composite = $builder->andX(
            $comparison1 = new ComparisonExpression('foo1', '=', 'bar1'),
            $comparison2 = new ComparisonExpression('foo2', '=', 'bar2'),
            $comparison3 = new ComparisonExpression('foo3', '=', 'bar3')
        );

        $expressions = $composite->getExpressions();

        static::assertSame(CompositeExpression::TYPE_AND, $composite->getType());
        static::assertSame($comparison1, $expressions[0]);
        static::assertSame($comparison2, $expressions[1]);
        static::assertSame($comparison3, $expressions[2]);
    }

    public function testOrX()
    {
        $builder = new ExpressionBuilder();

        $composite = $builder->orX(
            $comparison1 = new ComparisonExpression('foo1', '=', 'bar1'),
            $comparison2 = new ComparisonExpression('foo2', '=', 'bar2'),
            $comparison3 = new ComparisonExpression('foo3', '=', 'bar3')
        );

        $expressions = $composite->getExpressions();

        static::assertSame(CompositeExpression::TYPE_OR, $composite->getType());
        static::assertSame($comparison1, $expressions[0]);
        static::assertSame($comparison2, $expressions[1]);
        static::assertSame($comparison3, $expressions[2]);
    }

    public function provideComparisonExpressions()
    {
        return [
            ['eq', 'foo', ComparisonExpression::EQ, 'bar'],
            ['gt', 'foo', ComparisonExpression::GT, 'bar'],
            ['lt', 'foo', ComparisonExpression::LT, 'bar'],
            ['gte', 'foo', ComparisonExpression::GTE, 'bar'],
            ['lte', 'foo', ComparisonExpression::LTE, 'bar'],
            ['neq', 'foo', ComparisonExpression::NEQ, 'bar'],
            ['contains', 'foo', ComparisonExpression::CONTAINS, 'bar'],
            ['memberOf', 'foo', ComparisonExpression::MEMBER_OF, 'bar'],
            ['startsWith', 'foo', ComparisonExpression::STARTS_WITH, 'bar'],
            ['endsWith', 'foo', ComparisonExpression::ENDS_WITH, 'bar'],
        ];
    }

    /**
     * @dataProvider provideComparisonExpressions
     *
     * @param $method
     * @param $field
     * @param $operator
     * @param $value
     */
    public function testComparisonExpression($method, $field, $operator, $value)
    {
        $builder = new ExpressionBuilder();

        /* @var $expression ComparisonExpression */
        $expression = $builder->{$method}($field, $value);

        static::assertSame($field, $expression->getField());
        static::assertSame($operator, $expression->getOperator());
        static::assertSame($value, $expression->getValue()->getValue());
    }

    public function testIn()
    {
        $builder = new ExpressionBuilder();

        /* @var $expression ComparisonExpression */
        $expression = $builder->in('foo', ['bar']);

        static::assertSame('foo', $expression->getField());
        static::assertSame(ComparisonExpression::IN, $expression->getOperator());
        static::assertSame(['bar'], $expression->getValue()->getValue());
    }

    public function testNotIn()
    {
        $builder = new ExpressionBuilder();

        /* @var $expression ComparisonExpression */
        $expression = $builder->notIn('foo', ['bar']);

        static::assertSame('foo', $expression->getField());
        static::assertSame(ComparisonExpression::NIN, $expression->getOperator());
        static::assertSame(['bar'], $expression->getValue()->getValue());
    }
}
