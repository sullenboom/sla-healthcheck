<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 28.08.14
 * Time: 13:33
 */

namespace HealthCheck\Model\Service;


interface ServiceInterface
{
    public function isChild();

    public function getType();

    public function getName();

    public function setStatus($status, $onlyIfWorse = false);
    public function getStatus();
}