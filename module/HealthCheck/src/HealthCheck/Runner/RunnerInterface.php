<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 17:18
 */

namespace HealthCheck\Runner;

use HealthCheck\Model\Service;

interface RunnerInterface
{
    static public function run(Service\ServiceAbstract $service);
}