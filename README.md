[![Build Status](https://github.com/Crowdstar/reflection/workflows/Tests/badge.svg)](https://github.com/Crowdstar/reflection/actions)
[![Latest Stable Version](https://poser.pugx.org/Crowdstar/reflection/v/stable.svg)](https://packagist.org/packages/crowdstar/reflection)
[![Latest Unstable Version](https://poser.pugx.org/Crowdstar/reflection/v/unstable.svg)](https://packagist.org/packages/crowdstar/reflection)
[![License](https://poser.pugx.org/Crowdstar/reflection/license.svg)](https://packagist.org/packages/crowdstar/reflection)

A PHP reflection library to directly access protected/private properties and call protected/private methods.

This library works with major versions of PHP from 5.3 to 7.4.

# Installation

```bash
composer require crowdstar/reflection:~1.0.0
```

# Sample Usage

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use CrowdStar\Reflection\Reflection;

class Helper
{
    private $key;
    private static $keyStatic;

    private function get() {
        return 'private method invoked';
    }
    private static function getStatic(int $i, int $j) {
        return "private static method invoked with parameter {$i} and {$j}";
    }
};

$helper = new Helper();

// Access properties and invoke methods from objects.
Reflection::setProperty($helper, 'key', 'value from a private property');
echo "Output 1: ", Reflection::getProperty($helper, 'key'), "\n";
echo "Output 2: ", Reflection::callMethod($helper, 'get'), "\n";

// Access static properties and invoke static methods from objects.
Reflection::setProperty($helper, 'keyStatic', 'value from a private static property');
echo "Output 3: ", Reflection::getProperty($helper, 'keyStatic'), "\n";
echo "Output 4: ", Reflection::callMethod($helper, 'getStatic', array(1, 2)), "\n";

// Static properties and methods can also be accessed/invoked from a class directly.
Reflection::setProperty(Helper::class, 'keyStatic', 'another value from a private static property');
echo "Output 5: ", Reflection::getProperty(Helper::class, 'keyStatic'), "\n";
echo "Output 6: ", Reflection::callMethod(Helper::class, 'getStatic', array(3, 4)), "\n";
?>
```
