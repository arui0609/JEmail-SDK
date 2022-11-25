<?php
/**
 *
 * User: songrui
 * Date: 2022/11/25
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\JEmail\Facades;

use Illuminate\Support\Facades\Facade;

class JEmail extends Facade
{
    /**
     * @method static boolean sendEmail(array $data)
     * @method static string getNewToken()
     **/

    protected static function getFacadeAccessor()
    {
        return 'JEmail';
    }
}
