<?php

namespace PE\Component\Query\Expression;

use PE\Component\Query\Exception\InvalidArgumentException;

class CompositeExpression implements ExpressionInterface
{
    const TYPE_AND = 'AND';
    const TYPE_OR  = 'OR';

    /**
     * @var string
     */
    private $type;

    /**
     * @var ExpressionInterface[]
     */
    private $expressions = [];

    /**
     * @param string                $type
     * @param ExpressionInterface[] $expressions
     *
     * @throws InvalidArgumentException
     */
    public function __construct($type, array $expressions)
    {
        $this->type = $type;

        if (!in_array($type, [static::TYPE_AND, static::TYPE_OR], true)) {
            throw new InvalidArgumentException('Type must be on of static::TYPE_* constants');
        }

        $this->setExpressions($expressions);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return ExpressionInterface[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * @param ExpressionInterface[] $expressions
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setExpressions(array $expressions)
    {
        $this->expressions = [];

        foreach ($expressions as $expression) {
            if (!($expression instanceof ExpressionInterface)) {
                throw new InvalidArgumentException('Expression must be instance of ' . ExpressionInterface::class);
            }

            $this->addExpression($expression);
        }

        return $this;
    }

    /**
     * @param ExpressionInterface $expression
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function addExpression(ExpressionInterface $expression)
    {
        if ($expression instanceof ValueExpression) {
            throw new InvalidArgumentException(
                'Values are not supported expressions as children of and/or expressions.'
            );
        }

        $this->expressions[] = $expression;
        return $this;
    }
}