<?php

namespace PE\Component\Query;

use PE\Component\Query\Exception\InvalidArgumentException;
use PE\Component\Query\Expression\ExpressionInterface;

class Join
{
    const TYPE_LEFT  = 'LEFT';
    const TYPE_RIGHT = 'RIGHT';
    const TYPE_INNER = 'INNER';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var ExpressionInterface|null
     */
    private $condition;

    /**
     * @param string                   $class
     * @param string                   $alias
     * @param ExpressionInterface|null $on
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function left($class, $alias, ExpressionInterface $on = null)
    {
        return new static(static::TYPE_LEFT, $class, $alias, $on);
    }

    /**
     * @param string                   $class
     * @param string                   $alias
     * @param ExpressionInterface|null $on
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function right($class, $alias, ExpressionInterface $on = null)
    {
        return new static(static::TYPE_RIGHT, $class, $alias, $on);
    }

    /**
     * @param string                   $class
     * @param string                   $alias
     * @param ExpressionInterface|null $on
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public static function inner($class, $alias, ExpressionInterface $on = null)
    {
        return new static(static::TYPE_INNER, $class, $alias, $on);
    }

    /**
     * @param string                   $type
     * @param string                   $class
     * @param string                   $alias
     * @param ExpressionInterface|null $on
     *
     * @throws InvalidArgumentException
     */
    public function __construct($type, $class, $alias, ExpressionInterface $on = null)
    {
        $this->class     = $class;
        $this->alias     = $alias;
        $this->condition = $on;

        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, [static::TYPE_LEFT, static::TYPE_RIGHT, static::TYPE_INNER], true)) {
            throw new InvalidArgumentException('Type must be one of static::TYPE_* constant');
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return ExpressionInterface|null
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param ExpressionInterface|null $condition
     *
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }
}