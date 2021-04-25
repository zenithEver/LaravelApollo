<?php
/**
 * Created by PhpStorm.
 * User: lkboy
 * Date: 2019/6/17
 * Time: 14:51
 */

namespace Sunaloe\ApolloLaravel\Console;

use Illuminate\Console\Command;

class WorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apollo:work {env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'apollo 配置更新监听';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applicationEnv = $this->argument('env');

        app('apollo.variable')->setEnvironmentVariable('APP_ENV', $applicationEnv);

        $apollo = app('apollo.service');
        $client = $apollo->getServer();

        $pid = getmypid();
        echo "start [$pid]\n";
        $err = '';
        try {
            $err = $apollo->startCallback();
        } catch (\Exception $e) {
            $err = $e->getMessage();
        }

        echo $err . "\n";
    }
}