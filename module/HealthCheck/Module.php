<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace HealthCheck;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use HealthCheck\View\Helper\ListViewToolbar;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()   {
        return array(
            'invokables' => array(
                'MenuHelper' => 'Application\View\Helper\MenuHelper',
            ),
            'factories' => array(
                'listViewToolbar' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    return new ListViewToolbar(
                        $locator->get('Router'), $locator->get('Request')
                    );
                },
            ),
        );
    }
}
