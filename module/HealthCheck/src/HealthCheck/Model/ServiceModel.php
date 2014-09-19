<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:56
 */

namespace HealthCheck\Model;

class ServiceModel extends ModelAbstract
{
    /**
     * Configuration model path
     *
     * @var string
     */
    protected $_modelPath = 'services';

    public function getList()
    {
        return $this->getSites();
    }

    public function getSites()
    {
        return $this->_config->get('sites');
    }

    public function getDomains()
    {
        return $this->_config->get('domain');
    }
}