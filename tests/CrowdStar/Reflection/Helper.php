<?php
/**************************************************************************
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
 *************************************************************************/

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
