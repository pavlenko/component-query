<?php

namespace PE\Component\Query;

use PE\Component\Query\Exception\InvalidArgumentException;
use PE\Component\Query\Expression\CompositeExpression;
use PE\Component\Query\Expression\ExpressionBuilder;
use PE\Component\Query\Expression\ExpressionInterface;

class Query
{
    /**
     * @var ExpressionBuilder
     */
    private static $expressionBuilder;

    /**
     * @var string[]
     */
    private $columns = [];

    /**
     * @var string[]
     */
    private $from = [];

    /**
     * @var Join[]
     */
    private $joins = [];

    /**
     * @var ExpressionInterface
     */
    private $where;

    /**
     * @var string[]
     */
    private $order = [];

    /**
     * @var string[]
     */
    private $group = [];

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * Creates an instance of the class.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Returns the expression builder.
     *
     * @return ExpressionBuilder
     */
    public static function expr()
    {
        if (self::$expressionBuilder === null) {
            self::$expressionBuilder = new ExpressionBuilder();
        }

        return self::$expressionBuilder;
    }

    /**
     * @param string[] $columns
     *
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param string $class
     * @param string $alias
     *
     * @return $this
     */
    public function from($class, $alias)
    {
        $this->from[$class] = $alias;
        return $this;
    }

    /**
     * @param string                   $class
     * @param string|null              $alias
     * @param ExpressionInterface|null $on
     * @param string                   $type
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function join($class, $alias = null, ExpressionInterface $on = null, $type = Join::TYPE_INNER)
    {
        if ($class instanceof Join) {
            $this->joins[] = $class;
        } else {
            if ($alias === null) {
                throw new InvalidArgumentException('Alias is required for join');
            }

            $this->joins[] = new Join($type, $class, $alias, $on);
        }

        return $this;
    }

    /**
     * @param ExpressionInterface $where
     * @param string              $type
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function where(ExpressionInterface $where, $type = null)
    {
        if ($type) {
            if ($this->where === null) {
                $this->where = $where;
            } else {
                $this->where = new CompositeExpression($type, [$this->where, $where]);
            }
        } else {
            $this->where = $where;
        }

        return $this;
    }

    /**
     * @param string|string[] $order
     *
     * @return $this
     */
    public function order($order)
    {
        if (is_string($order)) {
            if (strpos($order, ',') !== false) {
                $order = preg_split('#,\s+#', $order);
            } else {
                $order = (array) $order;
            }
        } else if (!is_array($order)) {
            $order = [$order];
        }

        foreach ((array) $order as $k => $v) {
            if (is_string($k)) {
                $this->order[$k] = $v;
            } else {
                $this->order[] = $v;
            }
        }

        return $this;
    }

    /**
     * @param string|string[] $field
     *
     * @return $this
     */
    public function group($field)
    {
        if (is_array($field)) {
            foreach ((array) $field as $item) {
                $this->group[] = $item;
            }
        } else {
            $this->group[] = $field;
        }

        return $this;
    }

    /**
     * @param int|null $offset
     *
     * @return $this
     */
    public function offset($offset = null)
    {
        $this->offset = $offset === null ? null : (int) $offset;
        return $this;
    }

    /**
     * @param int|null $limit
     *
     * @return $this
     */
    public function limit($limit = null)
    {
        $this->limit = $limit === null ? null : (int) $limit;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return string[]
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return Join[]
     */
    public function getJoins()
    {
        return $this->joins;
    }

    /**
     * @return ExpressionInterface
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @return string[]
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return string[]
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }
}