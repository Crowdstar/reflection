<?php

namespace CrowdStar\Tests\Reflection;

use CrowdStar\Reflection\Reflection;
use PHPUnit_Framework_TestCase;

/**
 * Class ReflectionTest
 *
 * @package CrowdStar\Tests\Reflection
 */
class ReflectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataGetObjectProperty()
    {
        return array(
            array(
                'protected property',
                'protectedProperty',
                'to get a protected property of an object',
            ),
            array(
                'private property',
                'privateProperty',
                'to get a private property of an object',
            ),
            array(
                'protected static property',
                'protectedStaticProperty',
                'to get a protected static property of an object',
            ),
            array(
                'private static property',
                'privateStaticProperty',
                'to get a private static property of an object',
            ),
        );
    }

    /**
     * @dataProvider dataGetObjectProperty
     * @covers Reflection::getPropert()
     * @param string $expected
     * @param string $propertyName
     * @param string $message
     */
    public function testGetObjectProperty($expected, $propertyName, $message)
    {
        $this->assertSame($expected, Reflection::getProperty(new Helper(), $propertyName), $message);
    }

    /**
     * @return array
     */
    public function dataGetStaticProperty()
    {
        return array(
            array(
                'protected static property',
                'protectedStaticProperty',
            ),
            array(
                'private static property',
                'privateStaticProperty',
            ),
        );
    }

    /**
     * @dataProvider dataGetStaticProperty
     * @covers Reflection::getPropert()
     * @param string $expected
     * @param string $propertyName
     */
    public function testGetStaticProperty($expected, $propertyName)
    {
        $helper = new Helper();

        $this->assertSame(
            $expected,
            Reflection::getProperty($helper, $propertyName),
            'to get a protected/private static property of an object'
        );
        $this->assertSame(
            $expected,
            Reflection::getProperty(get_class($helper), $propertyName),
            'to get a protected/private static property of a class'
        );
    }

    /**
     * @return array
     */
    public function dataSetObjectProperty()
    {
        return array(
            array(
                'protectedProperty',
                'a new value',
                'to get a protected property of an object',
            ),
            array(
                'privateProperty',
                'second new value',
                'to get a private property of an object',
            ),
            array(
                'protectedStaticProperty',
                'third new value',
                'to get a protected static property of an object',
            ),
            array(
                'privateStaticProperty',
                'forth new value',
                'to get a private static property of an object',
            ),
        );
    }

    /**
     * @dataProvider dataSetObjectProperty
     * @covers Reflection::setProperty()
     * @covers Reflection::getProperty()
     * @depends testGetObjectProperty
     * @param string $propertyName
     * @param string $value
     * @param string $message
     */
    public function testSetObjectProperty($propertyName, $value, $message)
    {
        $helper = new Helper();
        Helper::reset();
        Reflection::setProperty($helper, $propertyName, $value);
        $this->assertSame($value, Reflection::getProperty($helper, $propertyName), $message);
    }

    /**
     * @return array
     */
    public function dataSetStaticProperty()
    {
        return array(
            array(
                'protectedStaticProperty',
                'a new value',
            ),
            array(
                'privateStaticProperty',
                'another new value',
            ),
        );
    }

    /**
     * @dataProvider dataSetStaticProperty
     * @covers Reflection::setProperty()
     * @covers Reflection::getProperty()
     * @depends testGetStaticProperty
     * @param string $propertyName
     * @param string $value
     */
    public function testSetStaticProperty($propertyName, $value)
    {
        $helper = new Helper();

        foreach (array(get_class($helper), $helper) as $class) {
            Helper::reset();
            Reflection::setProperty($class, $propertyName, $value);

            $this->assertSame(
                $value,
                Reflection::getProperty($helper, $propertyName),
                'to get a protected/private static property of an object'
            );
            $this->assertSame(
                $value,
                Reflection::getProperty(get_class($helper), $propertyName),
                'to get a protected/private static property of a class'
            );
        }
    }

    /**
     * @return array
     */
    public function dataCallObjectMethod()
    {
        return array(
            array(
                'value returned from a protected method: a value',
                'callProtectedMethod',
                'a value',
                'to call a protected method of an object',
            ),
            array(
                'value returned from a private method: second value',
                'callPrivateMethod',
                'second value',
                'to call a private method of an object',
            ),
            array(
                'value returned from a protected static method: third value',
                'callProtectedStaticMethod',
                'third value',
                'to call a protected static method of an object',
            ),
            array(
                'value returned from a private static method: forth value',
                'callPrivateStaticMethod',
                'forth value',
                'to call a private static method of an object',
            ),
        );
    }

    /**
     * @dataProvider dataCallObjectMethod
     * @covers Reflection::callMethod()
     * @covers Reflection::getMethod()
     * @param string $expected
     * @param string $methodName
     * @param string $value
     * @param string $message
     */
    public function testCallObjectMethod($expected, $methodName, $value, $message)
    {
        $this->assertSame($expected, Reflection::callMethod(new Helper(), $methodName, array($value)), $message);
    }


    /**
     * @return array
     */
    public function dataCallStaticMethod()
    {
        return array(
            array(
                'value returned from a protected static method: a value',
                'callProtectedStaticMethod',
                'a value',
            ),
            array(
                'value returned from a private static method: another value',
                'callPrivateStaticMethod',
                'another value',
            ),
        );
    }

    /**
     * @dataProvider dataCallStaticMethod
     * @covers Reflection::getPropert()
     * @param string $expected
     * @param string $methodName
     * @param string $value
     */
    public function testCallStaticMethod($expected, $methodName, $value)
    {
        $helper = new Helper();

        $this->assertSame(
            $expected,
            Reflection::callMethod($helper, $methodName, array($value)),
            'to call a protected/private static method of an object'
        );
        $this->assertSame(
            $expected,
            Reflection::callMethod(get_class($helper), $methodName, array($value)),
            'to call a protected/private static method of a class'
        );
    }
}
