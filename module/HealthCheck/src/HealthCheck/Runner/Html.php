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

class Html extends RunnerAbstract
{
    static public function run(Service\ServiceAbstract $service)
    {
        $request = new Request();
        $client = new Client();
        $adapter = new Adapter\Curl();

        $request->setMethod('GET');
        $client->setAdapter($adapter);
        $client->setOptions(array(
            CURLOPT_CONNECTTIMEOUT => 120
        ));

        foreach ($service as $item) {
            if ( !($item instanceof Service\ServiceAbstract)) {
                continue;
            }

            if (!$item->isChild()) {
                continue;
            }

            $client->setUri($item->url);
            $response = $client->send($client->getRequest());
            $status = $response->getStatusCode();
            $item->setStatus($status, true);
        }
        return $service;
    }
} 