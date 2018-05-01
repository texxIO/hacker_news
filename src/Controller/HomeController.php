<?php
namespace HackerNews\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function indexAction( Application $app , Request $request)
    {
        $data['newsList'] = [
            ['title'=>'news 1','body'=>'text body content 1'],
            ['title'=>'news 2','body'=>'text body content 2'],
            ['title'=>'news 3','body'=>'text body content 3'],
        ];

        return new Response( $app['twig']->render('index.html.twig', $data) );

    }


    public function askAction( Application $app , Request $request )
    {
        return new Response('aaask');
    }
}