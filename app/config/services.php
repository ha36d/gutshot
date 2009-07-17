<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use \Gutshot\MyFlash\MyFlash as MyFlash;
use \Gutshot\MyFlash\MyFlashSession as MyFlashSession;
use Phalcon\Logger;

use Gutshot\Auth\Auth;
use Gutshot\Acl\Acl;
use Gutshot\Mail\Mail;
use Gutshot\Api\Api;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Register the global configuration as config
 */
$di->set('config', $config);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir . 'volt/',
                'compiledSeparator' => '_'
            ));

            $compiler = $volt->getCompiler();
            $compiler->addFunction('rand', 'mt_rand');
            return $volt;
        }
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
    return new MetaDataAdapter(array(
        'metaDataDir' => $config->application->cacheDir . 'metaData/'
    ));
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    // limit session to 1 hour
    session_set_cookie_params(7200);
    $session->start();
    return $session;
});

/**
 * Crypt service
 */
$di->set('crypt', function () use ($config) {
    $crypt = new Crypt();
    $crypt->setKey($config->application->cryptSalt);
    return $crypt;
});

/**
 * Dispatcher use a default namespace
 */
$di->set('dispatcher', function () {
    $eventsManager = new \Phalcon\Events\Manager();

    $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {

        // Handle 404 exceptions
        if ($exception instanceof DispatchException) {
            $dispatcher->forward(
                array(
                    'controller' => 'about',
                    'action' => 'show404'
                )
            );
            return false;
        }

    });

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Gutshot\Controllers');
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

/**
 * Loading routes from the routes.php file
 */
$di->set('router', function () {
    return require __DIR__ . '/routes.php';
});

/**
 * Flash service with custom CSS classes
 */
$di->set('flash', function () {
    return new MyFlash(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
 * Flash Session service with custom CSS classes
 */
$di->set('flashSession', function () {
    return new MyFlashSession(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});

/**
 * Custom authentication component
 */
$di->set('auth', function () {
    return new Auth();
});

/**
 * Mail service
 */
$di->set('mail', function () {
    return new Mail();
});

/**
 * Access Control List
 */
$di->set('acl', function () {
    return new Acl();
});

/**
 * Api Access
 */
$di->set('api', function () {
    return new Api();
});
