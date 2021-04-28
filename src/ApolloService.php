<?php


namespace Sunaloe\ApolloLaravel;


class ApolloService
{
    const ENV_HOST = [
        // dev环境
        'dev'   => 'http://apollo.58huihuahua.com:18081',
        // fat环境
        'fat'   => 'http://apollo.58huihuahua.com:18082',
        'uat'   => 'http://apollo.58huihuahua.com:18083',
        'beta1' => 'http://apollo.58huihuahua.com:18084',
        'beta2' => 'http://apollo.58huihuahua.com:18085',
        'beta3' => 'http://apollo.58huihuahua.com:18086',
        'pro'   => 'http://apollo.51huihuahua.com:8080',
        'gray'  => 'http://apollo.51huihuahua.com:8081'
    ];

    /**
     * @param $fileList
     * @throws \Exception
     */
    private function updateConfig($fileList)
    {
        $newConfig = [];
        foreach ($fileList as $file) {
            if (!is_file($file)) {
                throw new \Exception('config file no exists');
            }
            $c = require $file;
            if (is_array($c) && isset($c['configurations'])) {
                $newConfig = array_merge($newConfig, $c['configurations']);
            }
        }

        if (empty($newConfig)) {
            echo "No configuration data\n";
            return;
        }

        ApolloCache::save($newConfig);

        echo date('c') . ":update success\n";
    }

    /**
     * @return ApolloClient
     */
    public function getServer()
    {
        // 配置的环境
        $applicationEnv = env('APP_ENV');
        $apolloServer = self::ENV_HOST[$applicationEnv] ?? 'dev';

        $server = new ApolloClient(
            $apolloServer, config('apollo.appid'), config('apollo.namespaces'));
        $server->save_dir = config('apollo.save_dir');
        return $server;
    }

    /**
     * @throws \Exception
     */
    public function startCallback()
    {
        $saveDir = config('apollo.save_dir');
        $realSaveDir = realpath($saveDir);

        // 生产目录
        if(!is_dir($realSaveDir)) {
            mkdir($realSaveDir, 0777, true);
        }

        $list = glob($saveDir . DIRECTORY_SEPARATOR . 'apolloConfig.*');
        $this->updateConfig($list);
    }
}
