<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/13/17
 * Time: 6:39 AM
 */

namespace CraftedSystems\MicroMobile\Facades;

use Illuminate\Support\Facades\Facade;

class MicroMobileSMS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'micromobile-sms';
    }
}