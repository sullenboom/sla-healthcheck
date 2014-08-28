<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 25.08.14
 * Time: 16:56
 */

namespace HealthCheck\Model;

class Service extends ModelAbstract
{
    /**
     * Configuration model path
     *
     * @var string
     */
    protected $modelPath = 'services';

    /**
     * @return Service\Html
     */
    public function getList()
    {
        return $this->getSites();
    }

    /**
     * @return Service\Html
     */
    public function getSites()
    {
        $data = $this->data->sites;
        $sites = array();
        foreach ($data as $item) {
            $sites[] = array(
                'url' => $item
            );
        }
        return new Service\Html($sites);
    }

    /**
     * @return Service\Html
     */
    public function getDomains()
    {
        return new Service\Java($this->data->domains->toArray());
    }
}