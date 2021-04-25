<?php


namespace Sunaloe\ApolloLaravel;

use Illuminate\Support\Facades\Storage;

class InputVar
{
    public function input()
    {
        $ret = ApolloCache::get();
        $varObj = app('apollo.variable');
        foreach ($ret as $key => $val) {
            $key = sprintf("%s%s", 'apollo:', $key);
            $varObj->setEnvironmentVariable($key, $val);
        }
    }
}
