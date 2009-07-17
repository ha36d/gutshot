<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
    'Gutshot\Models' => $config->application->modelsDir,
    'Gutshot\Controllers' => $config->application->controllersDir,
    'Gutshot\Forms' => $config->application->formsDir,
    'Gutshot' => $config->application->libraryDir
));

$loader->register();

// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
