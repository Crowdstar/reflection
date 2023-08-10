[![Build Status](https://github.com/Crowdstar/reflection/workflows/Tests/badge.svg)](https://github.com/Crowdstar/reflection/actions)
[![Latest Stable Version](https://poser.pugx.org/Crowdstar/reflection/v/stable.svg)](https://packagist.org/packages/crowdstar/reflection)
[![Latest Unstable Version](https://poser.pugx.org/Crowdstar/reflection/v/unstable.svg)](https://packagist.org/packages/crowdstar/reflection)
[![License](https://poser.pugx.org/Crowdstar/reflection/license.svg)](https://packagist.org/packages/crowdstar/reflection)

A PHP reflection library to directly access protected/private properties and call protected/private methods. Static
properties and methods can also be accessed/invoked from a class directly.

This library works with major versions of PHP from 5.3 to 8.2.

# Installation

For PHP 8.0+, please use version 2.0:

```bash
composer require crowdstar/reflection:~2.0.0
```

For old versions of PHP (PHP 5.3 to PHP 7.4), please use version 1.0 instead:

```bash
composer require crowdstar/reflection:~1.0.0
```

# How To Use It

Three static methods are provided to access protected/private properties and call protected/private methods of an object/class:

* `CrowdStar\Reflection\Reflection::getProperty()`: Get current value of a property.
* `CrowdStar\Reflection\Reflection::setProperty()`: Set a new value to a property.
* `CrowdStar\Reflection\Reflection::callMethod()`: Call a method of a class/object.

Here is a sample code showing how to use them:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use CrowdStar\Reflection\Reflection;

class Helper
{
    private string $key;

    private static string $keyStatic;

    private function get(): string
    {
        return 'Private method invoked.';
    }

    private static function getStatic(int $i, int $j): string
    {
        return "Private static method invoked with parameter {$i} and {$j}.";
    }
}

$helper = new Helper();

// Access properties and invoke methods from objects.
Reflection::setProperty($helper, 'key', 'Set value to a private property.');
echo "Output 1: ", Reflection::getProperty($helper, 'key'), PHP_EOL;
echo "Output 2: ", Reflection::callMethod($helper, 'get'), PHP_EOL, PHP_EOL;

// Access static properties and invoke static methods from objects.
Reflection::setProperty($helper, 'keyStatic', 'Set value to a private static property.');
echo "Output 3: ", Reflection::getProperty($helper, 'keyStatic'), PHP_EOL;
echo "Output 4: ", Reflection::callMethod($helper, 'getStatic', [1, 2]), PHP_EOL, PHP_EOL;

// Static properties and methods can also be accessed/invoked from a class directly.
Reflection::setProperty(Helper::class, 'keyStatic', 'Set another value to a private static property.');
echo "Output 5: ", Reflection::getProperty(Helper::class, 'keyStatic'), PHP_EOL;
echo "Output 6: ", Reflection::callMethod(Helper::class, 'getStatic', [3, 4]), PHP_EOL;
?>
```
