<?php

namespace CrowdStar\Reflection;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class Reflection
 *
 * @package CrowdStar\Reflection
 */
class Reflection
{
    /**
     * Finds a property for the given class.
     *
     * @param object|string $class The class instance or name.
     * @param string $name The name of a property.
     * @param boolean $access Make the property accessible?
     * @return ReflectionProperty The property.
     * @throws Exception If the property does not exist.
     * @throws ReflectionException
     */
    public static function findProperty($class, $name, $access = true)
    {
        $reflection = new ReflectionClass($class);

        while (! $reflection->hasProperty($name)) {
            if (! ($reflection = $reflection->getParentClass())) {
                throw new Exception("Class '{$class}' does not have property '{$name}' defined.");
            }
        }

        $property = $reflection->getProperty($name);
        $property->setAccessible($access);

        return $property;
    }

    /**
     * Return current value of a property.
     *
     * @param object|string $class The class instance or name.
     * @param string $name The name of a property.
     * @return mixed The current value of the property.
     * @throws Exception If the property does not exist.
     * @throws ReflectionException
     */
    public static function getProperty($class, $name)
    {
        $property = static::findProperty((is_object($class) ? get_class($class) : $class), $name);

        return $property->getValue(is_object($class) ? $class : null);
    }

    /**
     * Set a new value to given property.
     *
     * @param object|string $class The class instance or name.
     * @param string $name The name of a property.
     * @param mixed $value The new value.
     * @return void
     * @throws Exception If the property does not exist.
     * @throws ReflectionException
     */
    public static function setProperty($class, $name, $value)
    {
        $property = static::findProperty((is_object($class) ? get_class($class) : $class), $name);

        return $property->setValue(is_object($class) ? $class : null, $value);
    }

    /**
     * Get a protected/private static/non-static method from given class.
     *
     * @param string $className
     * @param string $methodName
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    public static function getMethod($className, $methodName)
    {
        $class  = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * Call a protected/private static/non-static method from given class.
     *
     * @param string|object $class
     * @param string $methodName
     * @param array $args
     * @return mixed
     * @throws ReflectionException
     */
    public static function callMethod($class, $methodName, array $args = array())
    {
        $method = self::getMethod((is_object($class) ? get_class($class) : $class), $methodName);
        $class  = is_object($class) ? $class : (new $class());

        return $method->invokeArgs($class, $args);
    }
}
