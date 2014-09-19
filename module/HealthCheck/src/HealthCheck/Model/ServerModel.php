<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:55
 */

namespace HealthCheck\Model;

class ServerModel extends ModelAbstract
{
    /**
     * Configuration model path
     *
     * @var string
     */
    protected $_modelPath = 'server';

    public function getList()
    {
        return $this->getSites();
    }

    public function getHosts()
    {
        return $this->_config->get('hosts');
    }

    public function getDomains()
    {
        return $this->_config->get('domain');
    }
}