# PHP Abstract Enum

## Example 
~~~
<?php
namespace app\enums;

use ctur\base\Enum;

/**
 * @package app\enums
 */
class UserType extends Enum
{
    const USER = '1';
    const CLIENT = '2';
    const ADMIN = '3';
    const SUPER_ADMIN = '4';

    /**
     * @var array $list payment statuses.
     */
    protected static $list = [
        self::USER        => 'User',
        self::CLIENT      => 'Client',
        self::ADMIN       => 'Admin',
        self::SUPER_ADMIN => 'Super admin',
    ];
}
~~~

Enjoy, guys!
