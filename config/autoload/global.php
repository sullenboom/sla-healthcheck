<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 */
return array(
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Service-Manager',
                'route' => 'home',
            ),
            array(
                'label' => 'Service-Manager',
                'route' => 'healthcheck',
                'pages' => array(
                    array(
                        'label' => 'Search',
                        'route' => 'healthcheck'
                    ),
                ),
            ),
        ),
    )
);