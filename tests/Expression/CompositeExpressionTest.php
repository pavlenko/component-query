<?php

namespace PETest\Component\Query\Expression;

use PE\Component\Query\Exception\InvalidArgumentException;
use PE\Component\Query\Expression\CompositeExpression;
use PE\Component\Query\Expression\ValueExpression;

class CompositeExpressionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorThrowsExceptionIfTypeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new CompositeExpression('foo', []);
    }

    public function testConstructorThrowsExceptionIfExpressionIsInvalidInstance()
    {
        $this->expectException(InvalidArgumentException::class);
        new CompositeExpression(CompositeExpression::TYPE_OR, [new \stdClass()]);
    }

    public function testConstructorThrowsExceptionIfExpressionIsValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new CompositeExpression(CompositeExpression::TYPE_OR, [new ValueExpression('foo')]);
    }
}
