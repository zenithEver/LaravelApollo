<?php


namespace Sunaloe\ApolloLaravel;

/**
 * 缓存
 * Class ApolloCache
 * @package Sunaloe\ApolloLaravel
 */
class ApolloCache
{
    // 缓存文件
    const CACHE_FILE = '/var/cache/xiaoniuhyphp/apollo';

    /**
     * 内容
     * @var array
     */
    private static $contents = null;

    /**
     * 保存
     * @param array $fileContent
     */
    public static function save(array $fileContent): void
    {
        if(empty(config('apollo.appid'))){
            return;
        }

       try{
           file_put_contents(self::getCacheFilePath(), json_encode($fileContent));
       }catch (\Throwable $e){}
    }


    /**
     * 获取缓存内容
     * @return array
     */
    public static function get(): array
    {
        /**
         * 增加变量配置，避免每次进行IO读写
         */
        if(is_null(self::$contents) && !empty(config('apollo.appid'))) {
            try {
                self::$contents = file_get_contents(self::getCacheFilePath());
            } catch (\Throwable $e){
                self::$contents = [];
            }
        }

        return json_decode(self::$contents, true) ?? [];
    }

    public static function getConfig(string $key, $default = '') {
        $content = self::get();

        return $content[$key] ?? $default;
    }

    private static function getCacheFilePath()
    {
        return sprintf('%s_%s', self::CACHE_FILE, config('apollo.appid'));
    }
}
