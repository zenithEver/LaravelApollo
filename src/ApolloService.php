<?php


namespace Sunaloe\ApolloLaravel;


use Org\Multilinguals\Apollo\Client\ApolloClient;

class ApolloService
{
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

        app('apollo.cache')->save($newConfig);

        echo date('c') . ":update success\n";
    }

    /**
     * @return ApolloClient
     */
    public function getServer()
    {
        $server = new ApolloClient(
            config('apollo.server'), config('apollo.appid'), config('apollo.namespaces'));
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
