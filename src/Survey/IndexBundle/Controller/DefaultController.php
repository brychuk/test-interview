<?php

namespace Survey\IndexBundle\Controller;

use Survey\IndexBundle\Entity\Users;
use Survey\IndexBundle\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    protected $session;

    public function __construct(){

        $this->session = new Session();
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    public function indexAction(Request $request)
    {
        if (false !== ($needed = $this->isRedirectNeeded($request)) ) {
            return $needed;
        }
        $this->session->set('current_state', array( $request->get('_route'), $this->generateUrl( "index" ) ) );

        $form = $this->createForm(new Form\StepOne());

        return $this->render('SurveyIndexBundle:Default:index.html.twig',
            array( "form"=> $form->createView(), 'include' => 'SurveyIndexBundle:Default:step1.html.twig' )
        );
    }

    public function indexPostAction(Request $request)
    {
        if (!$request->isMethod("POST")) {
            return $this->redirect($this->generateUrl( "index" ));
        }

        $user = new Users();
        $form = $this->createForm(new Form\StepOne(), $user);
        $form->bind($request);

        $responseArray = array( 'success' => false, 'response' => '' );

        if (!$form->isValid()) {
            if ($request->isXmlHttpRequest()) {
                $responseArray['response'] =
                    $this->render('SurveyIndexBundle:Default:step1.html.twig', array( 'form' => $form->createView() ) )
                        ->getContent();

            } else {
                $responseArray['response'] =
                    $this->render( 'SurveyIndexBundle:Default:index.html.twig',
                        array( "form"=> $form->createView(), 'include' => 'SurveyIndexBundle:Default:step1.html.twig' )
                    )->getContent();
            }
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $user );
            $em->flush();

            $responseArray['response'] = $this->redirect(
                $this->generateUrl( 'step2_with_id', array('id' => $user->getId()) )
            );

            if ($request->isXmlHttpRequest()) {
                $responseArray['success'] = true;
                $form2 = $this->createForm( new Form\StepTwo() );
                $form2->get('id')->setData( $user->getId() );
                $responseArray['response'] = $this->render('SurveyIndexBundle:Default:step2.html.twig',
                    array( 'form' => $form2->createView() ) )->getContent();
            }

            $this->session->set('current_state', array( 'step2_with_id',
                $this->generateUrl( 'step2_with_id', array('id' => $user->getId()) ) )
            );
        }

        return $this->returnResponse( $request, $responseArray );
    }

    public function step2Action(Request $request)
    {
        if (false !== ($needed = $this->isRedirectNeeded($request)) ) {
            return $needed;
        }

        $id = ( $request->get('id') && 0 < $request->get('id') ) ? $request->get('id') : 0;
        $this->session->set('current_state', array( $request->get('_route'),
            $this->generateUrl( 'step2_with_id', array('id' => $id) ))
        );

        if ($id === 0) {
            return $this->redirect( $this->generateUrl( "index" ), 302 );
        }

        $form = $this->createForm( new Form\StepTwo() );
        $form->get('id')->setData( $id );

        return $this->render('SurveyIndexBundle:Default:index.html.twig',
            array( "form"=> $form->createView(), 'include' => 'SurveyIndexBundle:Default:step2.html.twig' )
        );
    }

    public function step2PostAction(Request $request)
    {
        if (!$request->isMethod("POST")) {
            return $this->redirect($this->generateUrl( "index" ));
        }

        $user = new Users();
        $form = $this->createForm(new Form\StepTwo(), $user);
        $form->bind( $request );
        $responseArray = array( 'success' => false, 'response' => '' );

        if (!$form->isValid()) {
            $responseArray['response'] = $this->render('SurveyIndexBundle:Default:step2.html.twig',
                array( 'form' => $form->createView() ) )->getContent();
        } else {
            $em = $this->getDoctrine()->getManager();
            $formData = $form->getData();

            $storedUser = $em->find( 'Survey\IndexBundle\Entity\Users', $formData->getId() );
            $storedUser->setFavouriteIceCream( $form->get('favouriteIceCream')->getData() );
            $storedUser->setFavouriteSuperhero( $form->get('favouriteSuperhero')->getData() );
            $storedUser->setFavouriteMovieStar( $form->get('favouriteMovieStar')->getData() );
            $storedUser->setWorldEndDate( $form->get('worldEndDate')->getData() );
            $storedUser->setSuperbowlWinner( $form->get('superbowlWinner')->getData() );
            $em->persist($storedUser);
            $em->flush();

            $responseArray['success'] = true;
            $responseArray['response'] = $this->render('SurveyIndexBundle:Default:final.html.twig',
                array( 'img' => $this->finalStage() ) )->getContent();
            $this->session->remove('current_state');
        }

        return $this->returnResponse( $request, $responseArray );
    }

    protected function finalStage()
    {
        $html = file_get_contents( 'http://www.gifbin.com/random' );
        $crawler = new Crawler($html);
        $attributes = $crawler->filterXPath( '//img[@id="gif"]' )->extract( array('src') );

        return $attributes[0] ? utf8_encode($attributes[0]) : '';
    }

    protected function returnResponse(Request $request, array $responseArray)
    {
        if ($request->isXmlHttpRequest()) {
            return new Response(json_encode($responseArray), 200, array( 'Content-Type'=>'application/json' ));
        } else {
            return new Response( $responseArray['response'], 200);
        }
    }

    protected function isRedirectNeeded(Request $request)
    {
        if ( $request->getMethod() === 'GET' && !$request->isXmlHttpRequest() && $this->session->has('current_state'))
        {
            $currentState = $this->session->get('current_state');
            if( $currentState && $currentState[0] !== $request->get('_route') ){
                print_r($currentState);
                print_r($request->get('_route'));
                return new RedirectResponse( $currentState[1] );
            }
        }

        return false;
    }
}

