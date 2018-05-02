<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();
$routes->add('/', new Route('/', array(
    '_controller' => 'HackerNews\Controller\HomeController::newAction',
)));

$routes->add('/comments', new Route('/comments', array(
    '_controller' => 'HackerNews\Controller\HomeController::commentsAction',

)));

$routes->add('/show', new Route('/show', array(
    '_controller' => 'HackerNews\Controller\HomeController::showAction',

)));

$routes->add('/ask', new Route('/ask', array(
    '_controller' => 'HackerNews\Controller\HomeController::askAction',

)));

$routes->add('/jobs', new Route('/jobs', array(
    '_controller' => 'HackerNews\Controller\HomeController::jobsAction',

)));

$routes->add('/submit', new Route('/submit', array(
    '_controller' => 'HackerNews\Controller\HomeController::submitAction',

)));

return $routes;