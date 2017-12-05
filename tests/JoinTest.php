<?php

namespace PETest\Component\Query;

use PE\Component\Query\Exception\InvalidArgumentException;
use PE\Component\Query\Join;
use PE\Component\Query\Query;

class JoinTest extends \PHPUnit_Framework_TestCase
{
    public function testLeft()
    {
        $join = Join::left('Class', 'alias', $expr = Query::expr()->eq('a', 'b'));

        static::assertInstanceOf(Join::class, $join);
        static::assertSame(Join::TYPE_LEFT, $join->getType());
        static::assertSame('Class', $join->getClass());
        static::assertSame('alias', $join->getAlias());
        static::assertSame($expr, $join->getCondition());
    }

    public function testRight()
    {
        $join = Join::right('Class', 'alias', $expr = Query::expr()->eq('a', 'b'));

        static::assertInstanceOf(Join::class, $join);
        static::assertSame(Join::TYPE_RIGHT, $join->getType());
        static::assertSame('Class', $join->getClass());
        static::assertSame('alias', $join->getAlias());
        static::assertSame($expr, $join->getCondition());
    }

    public function testInner()
    {
        $join = Join::inner('Class', 'alias', $expr = Query::expr()->eq('a', 'b'));

        static::assertInstanceOf(Join::class, $join);
        static::assertSame(Join::TYPE_INNER, $join->getType());
        static::assertSame('Class', $join->getClass());
        static::assertSame('alias', $join->getAlias());
        static::assertSame($expr, $join->getCondition());
    }

    public function testSetTypeThrowsExceptionIfTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        (Join::inner('Class', 'alias'))->setType('foo');
    }

    public function testSetClass()
    {
        $join = Join::inner('Class', 'alias');
        static::assertSame('class2', $join->setClass('class2')->getClass());
    }

    public function testSetAlias()
    {
        $join = Join::inner('Class', 'alias');
        static::assertSame('alias2', $join->setAlias('alias2')->getAlias());
    }

    public function testSetCondition()
    {
        $join = Join::inner('Class', 'alias');
        $expr = Query::expr()->eq('a', 'b');
        static::assertSame($expr, $join->setCondition($expr)->getCondition());
    }
}
