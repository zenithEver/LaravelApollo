<?php
namespace Sunaloe\ApolloLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool resetConfig()
 * @method static string|int get()
 *
 */

class Apollo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apollo.cache';
    }
}
