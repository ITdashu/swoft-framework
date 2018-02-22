<?php

namespace Swoft\Bootstrap\Listeners;

use Swoft\App;
use Swoft\Bean\Annotation\BeforeStart;
use Swoft\Bean\Collector\SwooleListenerCollector;
use Swoft\Bootstrap\Listeners\Interfaces\BeforeStartInterface;
use Swoft\Bootstrap\Server\AbstractServer;
use Swoft\Bootstrap\SwooleEvent;
use Swoft\Exception\InvalidArgumentException;

/**
 * the listener of before server start
 *
 * @BeforeStart()
 */
class BeforeStartListener implements BeforeStartInterface
{
    /**
     * @param AbstractServer $server
     */
    public function onBeforeStart(AbstractServer &$server)
    {
        // check task
        $this->checkTask();
    }

    /**
     * check task
     */
    private function checkTask( )
    {
        $settings = App::getAppProperties()->get("server");
        $settings = $settings['setting'];
        $collector = SwooleListenerCollector::getCollector();

        $isConfigTask = isset($settings['task_worker_num']) && $settings['task_worker_num'] > 0;
        $isInstallTask = isset($collector[SwooleEvent::TYPE_SERVER][SwooleEvent::ON_TASK]) && isset($collector[SwooleEvent::TYPE_SERVER][SwooleEvent::ON_FINISH]);

        if($isConfigTask && !$isInstallTask){
            throw new InvalidArgumentException("Please 'composer require swoft/task' or set task_worker_num=0 !");
        }

        if(!$isConfigTask && $isInstallTask){
            throw new InvalidArgumentException("Please set task_worker_num > 0 !");
        }
    }
}