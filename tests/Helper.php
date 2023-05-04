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

declare(strict_types=1);

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
    protected string $protectedProperty = 'protected property';

    private string $privateProperty = 'private property';

    protected static string $protectedStaticProperty = 'protected static property';

    private static string $privateStaticProperty = 'private static property';

    public function __construct($foo)
    {
        $foo = 'This parameter is present only to test calls to private/protected static methods.';
    }

    public static function reset(): void
    {
        self::$protectedStaticProperty = 'protected static property';
        self::$privateStaticProperty = 'private static property';
    }

    protected function callProtectedMethod(string $value): string
    {
        return 'value returned from a protected method: ' . $value;
    }

    protected function callPrivateMethod(string $value): string
    {
        return 'value returned from a private method: ' . $value;
    }

    protected static function callProtectedStaticMethod(string $value): string
    {
        return 'value returned from a protected static method: ' . $value;
    }

    protected static function callPrivateStaticMethod(string $value): string
    {
        return 'value returned from a private static method: ' . $value;
    }
}
