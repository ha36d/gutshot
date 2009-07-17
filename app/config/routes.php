<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/invitation/{code}/{email}', array(
    'controller' => 'session',
    'action' => 'signup'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));

$router->add('/articles/([0-9]+)', array(
    'controller' => 'articles',
    'action' => 'index',
    "input"      => 1, // ([0-9]{2})
));

$router->add('/articles/(news|faq|rules|instruction|prize)', array(
    'controller' => 'articles',
    'action' => 'index',
    "input"      => 1, // ([0-9]{2})
));

return $router;
