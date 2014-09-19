<?php
return array(
    'router' => array(
        'plugins' => array(
            'literal'  => 'Zend\Mvc\Router\Http\Literal',
            'regex'    => 'Zend\Mvc\Router\Http\Regex',
        ),
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'HealthCheck\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'servers' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/servers',
                    'defaults' => array(
                        '__NAMESPACE__' => 'HealthCheck\Controller',
                        'controller'    => 'Index',
                        'action'        => 'servers',
                    ),
                ),
            ),
            'healthcheck' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/healthcheck',
                    'defaults' => array(
                        '__NAMESPACE__' => 'HealthCheck\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'service' => array(
                        'type'    => 'Regex',
                        'options' => array(
                            'regex' => '-(?<service>[a-zA-Z0-9_-]+)(\.(?<format>(json|html|txt|xml)))?',
                            'defaults' => array(
                                'controller' => 'HealthCheck\Controller\Runner',
                                'action'     => 'service',
                                'service'    => 'none',
                                'format'     => 'html',
                            ),
                            'spec' => '-%service%.%format%',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'HealthCheck\Controller\Index' => 'HealthCheck\Controller\IndexController',
            'HealthCheck\Controller\Runner' => 'HealthCheck\Controller\RunnerController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'health-check/index/index'  => __DIR__ . '/../view/health-check/index/index.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            __DIR__ . '/../view/partial',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
