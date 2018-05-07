<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();
$routes->add('/', new Route('/', array(
    '_controller' => 'HackerNews\Controller\HomeController::newsAction',
)));

$routes->add('/new', new Route('/newest', array(
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

$routes->add('/item', new Route('/item/{id}', array(
    '_controller' => 'HackerNews\Controller\HomeController::itemAction',
)));

$routes->add('/from', new Route('/from/{url}/{type}', array(
    '_controller' => 'HackerNews\Controller\HomeController::fromAction',
)));

$routes->add('/user', new Route('/user/{id}', array(
    '_controller' => 'HackerNews\Controller\HomeController::userAction',
)));

return $routes;