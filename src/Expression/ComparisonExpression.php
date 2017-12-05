<?php

namespace PE\Component\Query\Expression;

class ComparisonExpression implements ExpressionInterface
{
    const EQ           = '=';
    const NEQ          = '<>';
    const LT           = '<';
    const LTE          = '<=';
    const GT           = '>';
    const GTE          = '>=';
    const IN           = 'IN';
    const NIN          = 'NIN';
    const CONTAINS     = 'CONTAINS';
    const MEMBER_OF    = 'MEMBER_OF';
    const STARTS_WITH  = 'STARTS_WITH';
    const ENDS_WITH    = 'ENDS_WITH';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $field
     * @param string $operator
     * @param mixed  $value
     */
    public function __construct($field, $operator, $value)
    {
        if (!($value instanceof ValueExpression)) {
            $value = new ValueExpression($value);
        }

        $this->field    = $field;
        $this->operator = $operator;
        $this->value    = $value;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}