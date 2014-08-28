<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:55
 */

namespace HealthCheck\Model;

class Server extends ModelAbstract
{
    /**
     * Configuration model path
     *
     * @var string
     */
    protected $modelPath = 'servers';

    /**
     * @return Service\Html
     */
    public function getList()
    {
        return $this->getHosts();
    }

    /**
     * @return Config
     */
    public function getHosts()
    {
        return $this->data->hosts;
    }

    /**
     * @return Config
     */
    public function getDomains()
    {
        return $this->data->domains;
    }
}