<?php
namespace HackerNews\Controller;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function newAction( Application $app , Request $request)
    {
        $data['newsList'] = [
            ['title'=>'news 1','body'=>'text body content 1'],
            ['title'=>'news 2','body'=>'text body content 2'],
            ['title'=>'news 3','body'=>'text body content 3'],
        ];

        return new Response( $app['twig']->render('index.html.twig', $data) );

    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function commentsAction( Application $app , Request $request )
    {
        return new Response('Comments section');
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function showAction( Application $app , Request $request )
    {
        return new Response('Show section');
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function askAction( Application $app , Request $request )
    {
        return new Response('Ask section');
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function jobsAction( Application $app , Request $request )
    {
        return new Response('Jobs sections');
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function submitAction( Application $app , Request $request )
    {
        return new Response('Nothing here. Just ignored.');
    }




}