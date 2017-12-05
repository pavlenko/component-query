<?php

namespace PETest\Component\Query;

use PE\Component\Query\Exception\InvalidArgumentException;
use PE\Component\Query\Expression\CompositeExpression;
use PE\Component\Query\Expression\ExpressionBuilder;
use PE\Component\Query\Join;
use PE\Component\Query\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $query1 = Query::create();
        $query2 = Query::create();

        static::assertInstanceOf(Query::class, $query1);
        static::assertInstanceOf(Query::class, $query2);

        static::assertNotSame($query1, $query2);
    }

    public function testExpr()
    {
        $expr1 = Query::expr();
        $expr2 = Query::expr();

        static::assertInstanceOf(ExpressionBuilder::class, $expr1);
        static::assertInstanceOf(ExpressionBuilder::class, $expr2);

        static::assertSame($expr1, $expr2);
    }

    public function testColumns()
    {
        $query = Query::create();

        $query->columns($columns = ['foo', 'bar']);
        static::assertSame($columns, $query->getColumns());

        $query->columns($columns = ['bar', 'baz']);
        static::assertSame($columns, $query->getColumns());
    }

    public function testFrom()
    {
        $query = Query::create();

        $query->from('Class1', 'c1');
        static::assertSame(['Class1' => 'c1'], $query->getFrom());

        $query->from('Class2', 'c2');
        static::assertSame(['Class1' => 'c1', 'Class2' => 'c2'], $query->getFrom());
    }

    public function testJoinWithArgumentsAndWithoutAliasThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        Query::create()->join('Class1');
    }

    public function testJoinWithArguments()
    {
        $query = Query::create();

        $query->join('Class1', 'c1', $expr = Query::expr()->eq('c1.a', 'c1.b'));

        $joins = $query->getJoins();

        /* @var $join Join */
        $join = current($joins);

        static::assertSame('Class1', $join->getClass());
        static::assertSame('c1', $join->getAlias());
        static::assertSame($expr, $join->getCondition());
        static::assertSame(Join::TYPE_INNER, $join->getType());
    }

    public function testJoinWithInstance()
    {
        $query = Query::create();

        $query->join($join = new Join(Join::TYPE_INNER, 'Class1', 'c1', $expr = Query::expr()->eq('c1.a', 'c1.b')));

        $joins = $query->getJoins();
        static::assertSame($join, current($joins));
    }

    public function testWhere()
    {
        $query = Query::create();
        $query->where($where = Query::expr()->eq('a', 'b'));

        static::assertSame($where, $query->getWhere());
    }

    public function testWhereOr()
    {
        $query = Query::create();
        $query->where($where1 = Query::expr()->eq('a', 'b'));
        $query->where($where2 = Query::expr()->eq('c', 'd'), CompositeExpression::TYPE_OR);

        /* @var $where CompositeExpression */
        $where = $query->getWhere();

        static::assertInstanceOf(CompositeExpression::class, $where);
        static::assertSame(CompositeExpression::TYPE_OR, $where->getType());

        $expressions = $where->getExpressions();

        static::assertSame($expressions[0], $where1);
        static::assertSame($expressions[1], $where2);
    }

    public function testWhereAnd()
    {
        $query = Query::create();
        $query->where($where1 = Query::expr()->eq('a', 'b'));
        $query->where($where2 = Query::expr()->eq('c', 'd'), CompositeExpression::TYPE_AND);

        /* @var $where CompositeExpression */
        $where = $query->getWhere();

        static::assertInstanceOf(CompositeExpression::class, $where);
        static::assertSame(CompositeExpression::TYPE_AND, $where->getType());

        $expressions = $where->getExpressions();

        static::assertSame($expressions[0], $where1);
        static::assertSame($expressions[1], $where2);
    }

    public function testWhereWithTypeIfNotAlreadySet()
    {
        $query = Query::create();
        $query->where($where1 = Query::expr()->eq('a', 'b'), CompositeExpression::TYPE_AND);

        static::assertSame($where1, $query->getWhere());
    }

    public function testOrderFromString()
    {
        $query = Query::create();
        $query->order('a ASC');

        static::assertSame(['a ASC'], $query->getOrder());
    }

    public function testOrderFromStringWithComma()
    {
        $query = Query::create();
        $query->order('a ASC, b DESC');

        static::assertSame(['a ASC', 'b DESC'], $query->getOrder());
    }

    public function testOrderFromArray()
    {
        $query = Query::create();
        $query->order(['a ASC', 'b' => 'DESC']);

        static::assertSame(['a ASC', 'b' => 'DESC'], $query->getOrder());
    }

    public function testOrderFromCustomObject()
    {
        $query = Query::create();
        $query->order($order = new \stdClass());

        static::assertSame([$order], $query->getOrder());
    }

    public function testGroup()
    {
        $query = Query::create();
        $query->group('foo');
        $query->group(['bar', 'baz']);

        static::assertSame(['foo', 'bar', 'baz'], $query->getGroup());
    }

    public function testLimit()
    {
        $query = Query::create();

        static::assertNull($query->getLimit());

        $query->limit(10);

        static::assertSame(10, $query->getLimit());

        $query->limit(null);

        static::assertNull($query->getLimit());
    }

    public function testOffset()
    {
        $query = Query::create();

        static::assertNull($query->getOffset());

        $query->offset(10);

        static::assertSame(10, $query->getOffset());

        $query->offset(null);

        static::assertNull($query->getOffset());
    }
}
