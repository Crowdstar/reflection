<?php

namespace CrowdStar\Tests\Reflection;

/**
 * Class Helper.
 *
 * A helper class for unit tests.
 *
 * @package CrowdStar\Reflection
 */
class Helper
{
    /**
     * @var string
     */
    protected $protectedProperty = 'protected property';

    /**
     * @var string
     */
    private $privateProperty = 'private property';

    /**
     * @var string
     */
    protected static $protectedStaticProperty = 'protected static property';

    /**
     * @var string
     */
    private static $privateStaticProperty = 'private static property';

    /**
     * @return void
     */
    public static function reset()
    {
        self::$protectedStaticProperty = 'protected static property';
        self::$privateStaticProperty   = 'private static property';
    }

    /**
     * @param string $value
     * @return string
     */
    protected function callProtectedMethod($value)
    {
        return 'value returned from a protected method: ' . $value;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function callPrivateMethod($value)
    {
        return 'value returned from a private method: ' . $value;
    }

    /**
     * @param string $value
     * @return string
     */
    protected static function callProtectedStaticMethod($value)
    {
        return 'value returned from a protected static method: ' . $value;
    }

    /**
     * @param string $value
     * @return string
     */
    protected static function callPrivateStaticMethod($value)
    {
        return 'value returned from a private static method: ' . $value;
    }
}
