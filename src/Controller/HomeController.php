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
     * @throws \Exception
     */

    public function newsAction( Application $app , Request $request)
    {

        try {

            $app['hnApi']->setType($app['config']['api_requests']['topstories']);
            $data['stories'] = $app['hnApi']->get()->getAllItems();
        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }

        return new Response( $app['twig']->render('index.html.twig', $data) );

    }

    public function newAction( Application $app , Request $request)
    {
        try {

            $app['hnApi']->setType($app['config']['api_requests']['newstories']);
            $data['stories'] = $app['hnApi']->get()->getAllItems();
        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }

        return new Response( $app['twig']->render('index.html.twig', $data) );

    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function commentsAction( Application $app , Request $request )
    {
        $data['message'] = 'No API method available for this request';
        return new Response( $app['twig']->render('nothinghere.html.twig', $data) );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function showAction( Application $app , Request $request )
    {
         try {

             $app['hnApi']->setType($app['config']['api_requests']['showstories']);
             $data['stories'] = $app['hnApi']->get()->getAllItems();
         }catch( \Exception $e )
         {
             //DEBUG ONLY -  check the error log for the message
             echo $e->getMessage();
         }
         catch ( \Error $e )
         {
             //DEBUG ONLY -  check the error log for the message
             echo $e->getMessage();
         }

        return new Response( $app['twig']->render('index.html.twig', $data) );

    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function askAction( Application $app , Request $request )
    {
        try {

            $app['hnApi']->setType($app['config']['api_requests']['askstories']);
            $data['stories'] = $app['hnApi']->get()->getAllItems();
        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }

        return new Response( $app['twig']->render('index.html.twig', $data) );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function jobsAction( Application $app , Request $request )
    {
        try {

            $app['hnApi']->setType($app['config']['api_requests']['jobstories']);
            $data['stories'] = $app['hnApi']->get()->getAllItems();
        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }

        return new Response( $app['twig']->render('jobs.html.twig', $data) );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function submitAction( Application $app , Request $request )
    {
        $data['message'] = 'This is out of scope.';
        return new Response( $app['twig']->render('nothinghere.html.twig', $data) );
    }

    public function itemAction( int $id,  Application $app, Request $request )
    {
        try {

            $app['hnApi']->setType($app['config']['api_requests']['item']);
            $data['item'] = $app['hnApi']->get($id)->getItemDetails();

        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }


        return new Response( $app['twig']->render('item.html.twig', $data) );
    }

    /**
     * @param string $url
     * @param string $type
     * @param Application $app
     * @return mixed
     */
    public function fromAction( string $url , string $type = 'web', Application $app)
    {
        if ( $type == 'web' ) {
            $url = urlencode($url);
            return $app->redirect('http://' . $url, 301);
        }
        elseif ( $type == 'google' )
        {
            $url = urlencode($url);
            return $app->redirect('https://www.google.com/search?q=' . $url, 301);
        }
    }

    public function userAction( string $id,  Application $app, Request $request )
    {
        try {

            $app['hnApi']->setType($app['config']['api_requests']['user']);
            $data['user'] = $app['hnApi']->get($id)->getUserDetails();

        }catch( \Exception $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }
        catch ( \Error $e )
        {
            //DEBUG ONLY -  check the error log for the message
            echo $e->getMessage();
        }

        return new Response( $app['twig']->render('user.html.twig', $data) );
    }



}