<?php

return [
    /**
     * apollo 服务器
     */
    'env' => 'dev',

    /**
     *
     */
    'save_dir' => './bootstrap/cache/apollo',

    /**
     * apollo 配置appid
     */
    'appid' => 'ocr',

    /**
     * 读取的namespace
     */
    'namespaces' => ['application', 'ocrMysql', 'ocrRedis'],
];
