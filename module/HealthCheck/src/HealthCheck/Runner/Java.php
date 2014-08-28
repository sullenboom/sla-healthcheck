<?php
/**
 * Created by PhpStorm.
 * User: sullenboom
 * Date: 26.08.14
 * Time: 17:17
 */

namespace HealthCheck\Runner;

use HealthCheck\Model\Service;

use Zend\Config;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Http\Client\Adapter;

class Java extends RunnerAbstract
{
    static public function run(Service\ServiceAbstract $service)
    {
        $request = new Request();
        $client = new Client();
        $adapter = new Adapter\Curl();

        $request->setMethod('GET');
        $client->setAdapter($adapter);

        foreach ($service as $url) {
            if (!is_string($url)) {
                continue;
            }
            $client->setUri($url);
            $response = $client->send($client->getRequest());
            echo $url . " --> " . $response->getStatusCode();
        }
    }
} 