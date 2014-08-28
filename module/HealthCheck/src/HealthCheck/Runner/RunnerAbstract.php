<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 17:18
 */

namespace HealthCheck\Runner;

use HealthCheck\Model\Service;

use Zend\Config;

class RunnerAbstract implements RunnerInterface
{
    static public function run(Service\ServiceAbstract $service)
    {
        throw new Exception\RuntimeException('Have to be implemented');
    }

    /**
     * @param array $array
     * @param $classOrName
     * @return Service\ServiceAbstract
     * @throws Exception\InvalidArgumentException
     */
    static public function transformData(array $array, $classOrName)
    {
        $class = $classOrName;
        if (is_object($classOrName)) {
            $class = $classOrName;
        } elseif (is_scalar($classOrName) && class_exists($classOrName)) {
            $class = new $classOrName;
        }
        if ( !($class instanceof Service\ServiceAbstract) ) {
            throw new \InvalidArgumentException(sprintf(
               'Class "%s" not found or not an instance of Model\Service\ServiceInterface',
                $classOrName
            ));
        }
        return $class->mergeArray($array);
    }
} 