<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();
$routes->add('/', new Route('/', array(
    '_controller' => 'HackerNews\Controller\HomeController::indexAction',
)));

$routes->add('/ask', new Route('/ask', array(
    '_controller' => 'HackerNews\Controller\HomeController::askAction',

)));

return $routes;