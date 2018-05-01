<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

//var_dump($routes);

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\RoutingServiceProvider());
$app['routes'] = $routes;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views', // The path to the views, which is in our case points to /var/www/views
));

$app->run();

