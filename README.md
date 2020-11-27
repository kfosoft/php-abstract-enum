# PHP Abstract Enumeration
## Installation

Installation with Composer

Either run
~~~
    php composer.phar require --prefer-dist kfosoft/php-abstract-enum:"*"
~~~
or add in composer.json
~~~
    "require": {
            ...
            "kfosoft/php-abstract-enum": "*"
    }
~~~

## Example 
~~~
<?php
namespace app\enums;

use KFOSOFT\Domain\Enumeration\AbstractEnumeration;

/**
 * @package app\enums
 */
class UserType extends AbstractEnumeration
{
    const USER        = 1;
    const CLIENT      = 2;
    const ADMIN       = 3;
    const SUPER_ADMIN = 4;
}
~~~

Enjoy, guys!
