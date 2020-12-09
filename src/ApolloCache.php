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
     * 保存
     * @param array $fileContent
     */
    public function save(array $fileContent): void
    {
        file_put_contents(self::CACHE_FILE, json_encode($fileContent));
    }


    /**
     * 获取缓存内容
     * @return array
     */
    public function get(): array
    {
        $content = file_get_contents(self::CACHE_FILE);

        return json_decode($content, true) ?? [];
    }
}
