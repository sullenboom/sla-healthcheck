<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 17:18
 */

namespace HealthCheck\Model;

interface ModelInterface
{
    /**
     * @return Service\Html
     */
    public function getList();

    public function getType();

    public function getName();

    public function setAppName($name);
    public function getAppName();
}