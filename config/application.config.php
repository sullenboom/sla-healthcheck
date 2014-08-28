<?php
return array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'HealthCheck',
    ),

    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),

        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,%s,local}.php',
        )
    ),

    // Used to create an own service manager. May contain one or more child arrays.
    //'service_listener_options' => array(
    //     array(
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ),
    // )

    // Initial configuration with which to seed the ServiceManager.
    // Should be compatible with Zend\ServiceManager\Config.
    // 'service_manager' => array(),

    // Use the $env value to determine the state of the flag
    'config_cache_enabled' => ($env == 'production'),

    'config_cache_key' => 'app_config',

    // Use the $env value to determine the state of the flag
    'module_map_cache_enabled' => ($env == 'production'),

    'module_map_cache_key' => 'module_map',

    'cache_dir' => 'data/cache/',

    // Use the $env value to determine the state of the flag
    'check_dependencies' => ($env != 'production'),
);
