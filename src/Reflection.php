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

/**
 * Class Reflection
 */
class Reflection
{
    /**
     * Finds a property for the given class.
     *
     * @param object|class-string $class The class instance or name.
     * @param string $name The name of a property.
     * @param bool $access Make the property accessible?
     * @return \ReflectionProperty The property.
     * @throws Exception If the property does not exist.
     * @throws \ReflectionException
     */
    public static function findProperty(object|string $class, string $name, bool $access = true): \ReflectionProperty
    {
        $reflection = new \ReflectionClass($class);

        while (!$reflection->hasProperty($name)) {
            if (!($reflection = $reflection->getParentClass())) {
                throw new Exception(sprintf(
                    'Class "%s" does not have property "%s" defined.',
                    (is_object($class) ? get_class($class) : $class),
                    $name
                ));
            }
        }

        $property = $reflection->getProperty($name);
        $property->setAccessible($access);

        return $property;
    }

    /**
     * Return current value of a property.
     *
     * @param object|class-string $class The class instance or name.
     * @param string $name The name of a property.
     * @return mixed The current value of the property.
     * @throws Exception If the property does not exist.
     * @throws \ReflectionException
     */
    public static function getProperty(object|string $class, string $name): mixed
    {
        $property = static::findProperty(is_object($class) ? get_class($class) : $class, $name);

        return $property->getValue(is_object($class) ? $class : null);
    }

    /**
     * Set a new value to given property.
     *
     * @param object|class-string $class The class instance or name.
     * @param string $name The name of a property.
     * @param mixed $value The new value.
     * @throws Exception If the property does not exist.
     * @throws \ReflectionException
     */
    public static function setProperty(object|string $class, string $name, mixed $value): void
    {
        $property = static::findProperty(is_object($class) ? get_class($class) : $class, $name);
        $property->setValue(is_object($class) ? $class : null, $value);
    }

    /**
     * Get a protected/private static/non-static method from given class.
     *
     * @param class-string $className The class name.
     * @throws \ReflectionException
     */
    public static function getMethod(string $className, string $methodName): \ReflectionMethod
    {
        $r      = new \ReflectionClass($className);
        $method = $r->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * Call a protected/private static/non-static method from given class.
     *
     * @param object|class-string $class The class instance or name.
     * @param array<mixed> $args The arguments to pass to the method.
     * @throws Exception
     * @throws \ReflectionException
     */
    public static function callMethod(object|string $class, string $methodName, array $args = []): mixed
    {
        $method = self::getMethod(is_object($class) ? get_class($class) : $class, $methodName);
        if ($method->isStatic()) {
            return $method->invokeArgs(null, $args);
        }

        if (is_string($class)) {
            $constructor = (new \ReflectionClass($class))->getConstructor();
            if (isset($constructor) && ($constructor->getNumberOfRequiredParameters() > 0)) {
                throw new Exception("The constructor of class '{$class}' has some required parameters.");
            }

            $class = new $class();
        }

        return $method->invokeArgs($class, $args);
    }
}
