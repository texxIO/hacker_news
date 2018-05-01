<?php
namespace HackerNews\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class GlobalControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/','HackerNews\Controller\HomeController::indexAction' )->bind('homepage');
        return $controllers;
    }

}