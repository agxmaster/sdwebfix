<?php
namespace SwooleDistributedWeb\app;

use Server\CoreBase\HttpInput;
use Server\CoreBase\Loader;
use SwooleDistributedWeb\Server\SwooleDistributedServer;
use Server\Components\Backstage\BackstageHelp;

/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-9-19
 * Time: 下午2:36
 */
class AppServer extends SwooleDistributedServer
{
    /**
     * 可以在这里自定义Loader，但必须是ILoader接口
     * AppServer constructor.
     */
    public function __construct()
    {
        $this->setLoader(new Loader());
        parent::__construct();
    }
    
    /**
     * 可以在这修改配置
     */
    protected function setConfig()
    {
        parent::setConfig();
        BackstageHelp::init("0.0.0.0", "18083");
    }

    /**
     * 开服初始化(支持协程)
     * @return mixed
     */
    public function onOpenServiceInitialization()
    {
        yield parent::onOpenServiceInitialization();
    }

    /**
     * 当一个绑定uid的连接close后的清理
     * 支持协程
     * @param $uid
     */
    public function onUidCloseClear($uid)
    {
        // TODO: Implement onUidCloseClear() method.
    }

    /**
     * 这里可以进行额外的异步连接池，比如另一组redis/mysql连接
     * @param $workerId
     * @return array
     */
    public function initAsynPools($workerId)
    {
        parent::initAsynPools($workerId);
    }

    /**
     * 用户进程
     */
    public function startProcess()
    {
        parent::startProcess();
        //ProcessManager::getInstance()->addProcess(MyProcess::class);
    }

    /**
     * 可以在这验证WebSocket连接,return true代表可以握手，false代表拒绝
     * @param HttpInput $httpInput
     * @return bool
     */
    public function onWebSocketHandCheck(HttpInput $httpInput)
    {
        return true;
    }
    
    /**
     * @return string
     */
    public function getCloseMethodName()
    {
        return 'onClose';
    }
    
    /**
     * @return string
     */
    public function getEventControllerName()
    {
        return get_instance()->config->get('http.default_controller');
    }
    
    /**
     * @return string
     */
    public function getConnectMethodName()
    {
        return 'onConnect';
    }
}