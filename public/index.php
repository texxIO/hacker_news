<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';
require_once __DIR__ . '/../config/config.php';
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\RoutingServiceProvider());

$app['routes'] = $routes;
$app['config'] = $config;

//TODO - if we have time...
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => $app['config']['db']['sqlite']['path'],
    ),
));

$api = new HackerNews\Helpers\HackerNewsApi($config['api_requests']);
$api->setUrl($app['config']['api_url']);

$app['hnApi'] = $api;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views', // The path to the views, which is in our case points to /var/www/views
));


$app->run();

