<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace HealthCheck\Controller;

use HealthCheck\Model;
use HealthCheck\Runner;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model as ViewModel;
use Zend\View\Renderer;
use Zend\Json;
use Zend\Filter;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $services = Model\Factory::fromDirectory('services');

        $view = new ViewModel\ViewModel();
        $view->services = $services;
        return $view;
    }

    public function serversAction()
    {
        $servers = Model\Factory::fromDirectory('servers');

        $view = new ViewModel\ViewModel();
        $view->servers = $servers;
        return $view;
    }
}
