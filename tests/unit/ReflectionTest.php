<?php
/**
 * Copyright 2018 Glu Mobile Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace CrowdStar\Reflection;

use PHPUnit\Framework\TestCase;

/**
 * Class ReflectionTest
 *
 * @internal
 * @coversNothing
 */
class ReflectionTest extends TestCase
{
    /**
     * @return array<array<string>>
     */
    public static function dataGetObjectProperty(): array
    {
        return [
            [
                'protected property',
                'protectedProperty',
                'to get a protected property of an object',
            ],
            [
                'private property',
                'privateProperty',
                'to get a private property of an object',
            ],
            [
                'protected static property',
                'protectedStaticProperty',
                'to get a protected static property of an object',
            ],
            [
                'private static property',
                'privateStaticProperty',
                'to get a private static property of an object',
            ],
        ];
    }

    /**
     * @dataProvider dataGetObjectProperty
     * @covers       \CrowdStar\Reflection\Reflection::getPropert()
     */
    public function testGetObjectProperty(string $expected, string $propertyName, string $message): void
    {
        $this->assertSame($expected, Reflection::getProperty(new Helper('foo'), $propertyName), $message);
    }

    /**
     * @return array<array<string>>
     */
    public static function dataGetStaticProperty(): array
    {
        return [
            [
                'protected static property',
                'protectedStaticProperty',
            ],
            [
                'private static property',
                'privateStaticProperty',
            ],
        ];
    }

    /**
     * @dataProvider dataGetStaticProperty
     * @covers       \CrowdStar\Reflection\Reflection::getPropert()
     */
    public function testGetStaticProperty(string $expected, string $propertyName): void
    {
        $helper = new Helper('foo');

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
     * @return array<array<string>>
     */
    public static function dataSetObjectProperty(): array
    {
        return [
            [
                'protectedProperty',
                'a new value',
                'to get a protected property of an object',
            ],
            [
                'privateProperty',
                'second new value',
                'to get a private property of an object',
            ],
            [
                'protectedStaticProperty',
                'third new value',
                'to get a protected static property of an object',
            ],
            [
                'privateStaticProperty',
                'forth new value',
                'to get a private static property of an object',
            ],
        ];
    }

    /**
     * @dataProvider dataSetObjectProperty
     * @covers       \CrowdStar\Reflection\Reflection::getProperty()
     * @covers       \CrowdStar\Reflection\Reflection::setProperty()
     * @depends      testGetObjectProperty
     */
    public function testSetObjectProperty(string $propertyName, string $value, string $message): void
    {
        $helper = new Helper('foo');
        Helper::reset();
        Reflection::setProperty($helper, $propertyName, $value);
        $this->assertSame($value, Reflection::getProperty($helper, $propertyName), $message);
    }

    /**
     * @return array<array<string>>
     */
    public static function dataSetStaticProperty(): array
    {
        return [
            [
                'protectedStaticProperty',
                'a new value',
            ],
            [
                'privateStaticProperty',
                'another new value',
            ],
        ];
    }

    /**
     * @dataProvider dataSetStaticProperty
     * @covers       \CrowdStar\Reflection\Reflection::getProperty()
     * @covers       \CrowdStar\Reflection\Reflection::setProperty()
     * @depends      testGetStaticProperty
     */
    public function testSetStaticProperty(string $propertyName, string $value): void
    {
        $helper = new Helper('foo');

        foreach ([get_class($helper), $helper] as $class) {
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
     * @return array<array<string>>
     */
    public static function dataCallObjectMethod(): array
    {
        return [
            [
                'value returned from a protected method: a value',
                'callProtectedMethod',
                'a value',
                'to call a protected method of an object',
            ],
            [
                'value returned from a private method: second value',
                'callPrivateMethod',
                'second value',
                'to call a private method of an object',
            ],
            [
                'value returned from a protected static method: third value',
                'callProtectedStaticMethod',
                'third value',
                'to call a protected static method of an object',
            ],
            [
                'value returned from a private static method: forth value',
                'callPrivateStaticMethod',
                'forth value',
                'to call a private static method of an object',
            ],
        ];
    }

    /**
     * @dataProvider dataCallObjectMethod
     * @covers       \CrowdStar\Reflection\Reflection::callMethod()
     * @covers       \CrowdStar\Reflection\Reflection::getMethod()
     */
    public function testCallObjectMethod(string $expected, string $methodName, string $value, string $message): void
    {
        $this->assertSame($expected, Reflection::callMethod(new Helper('foo'), $methodName, [$value]), $message);
    }

    /**
     * @return array<array<string>>
     */
    public static function dataCallStaticMethod(): array
    {
        return [
            [
                'value returned from a protected static method: a value',
                'callProtectedStaticMethod',
                'a value',
            ],
            [
                'value returned from a private static method: another value',
                'callPrivateStaticMethod',
                'another value',
            ],
        ];
    }

    /**
     * @dataProvider dataCallStaticMethod
     * @covers       \CrowdStar\Reflection\Reflection::getPropert()
     */
    public function testCallStaticMethod(string $expected, string $methodName, string $value): void
    {
        $helper = new Helper('foo');

        $this->assertSame(
            $expected,
            Reflection::callMethod($helper, $methodName, [$value]),
            'to call a protected/private static method of an object'
        );
        $this->assertSame(
            $expected,
            Reflection::callMethod(get_class($helper), $methodName, [$value]),
            'to call a protected/private static method of a class'
        );
    }

    /**
     * @covers \CrowdStar\Reflection\Reflection::callMethod()
     */
    public function testCallNonStaticMethodWithoutObject(): void
    {
        if (method_exists($this, 'setExpectedException')) {
            // PHPUnit 4
            $this->setExpectedException(
                'CrowdStar\Reflection\Exception',
                "The constructor of class 'CrowdStar\\Reflection\\Helper' has some required parameters."
            );
        } else {
            $this->expectException('CrowdStar\Reflection\Exception');
            $this->expectExceptionMessage(
                "The constructor of class 'CrowdStar\\Reflection\\Helper' has some required parameters."
            );
        }

        Reflection::callMethod('CrowdStar\Reflection\Helper', 'callProtectedMethod', ['dummy']);
    }
}
