<?php

namespace PE\Component\Query\Expression;

use PE\Component\Query\Exception\InvalidArgumentException;

class ExpressionBuilder
{
    /**
     * @param mixed $x
     *
     * @return CompositeExpression
     *
     * @throws InvalidArgumentException
     */
    public function andX($x = null)
    {
        return new CompositeExpression(CompositeExpression::TYPE_AND, func_get_args());
    }

    /**
     * @param mixed $x
     *
     * @return CompositeExpression
     *
     * @throws InvalidArgumentException
     */
    public function orX($x = null)
    {
        return new CompositeExpression(CompositeExpression::TYPE_OR, func_get_args());
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function eq($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::EQ, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function gt($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::GT, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function lt($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::LT, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function gte($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::GTE, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function lte($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::LTE, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function neq($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::NEQ, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $values
     *
     * @return ComparisonExpression
     */
    public function in($field, array $values)
    {
        return new ComparisonExpression($field, ComparisonExpression::IN, new ValueExpression($values));
    }

    /**
     * @param string $field
     * @param mixed  $values
     *
     * @return ComparisonExpression
     */
    public function notIn($field, array $values)
    {
        return new ComparisonExpression($field, ComparisonExpression::NIN, new ValueExpression($values));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function contains($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::CONTAINS, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function memberOf($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::MEMBER_OF, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function startsWith($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::STARTS_WITH, new ValueExpression($value));
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return ComparisonExpression
     */
    public function endsWith($field, $value)
    {
        return new ComparisonExpression($field, ComparisonExpression::ENDS_WITH, new ValueExpression($value));
    }
}