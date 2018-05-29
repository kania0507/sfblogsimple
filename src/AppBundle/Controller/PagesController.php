<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller {
    
    /**
     * @Route(
     *      "/about",
     *      name="about"
     * )
     * 
     * 
     */
    public function aboutAction(){
		
		return $this->render('page/about.html.twig', array());
		

    }
    
    
        
    
    /**
     * @Route("/contact")
     */
    public function contantPageAction(){
        return $this->forward('EduwebTrainingBundle:Pages:printHeader', array(
            'title' => 'Kontakt',
            'color' => 'blue'
        ));
    }
    
    
    /**
     * @Route("/generate-error")
     */
    public function generateErrorAction(){
        //throw $this->createNotFoundException('Ta strona nie została znaleziona!');
        
        throw new \Exception('Ups. Wystąpił błąd aplikacji.');
    }
    
    
    
    /**
     * @Route("/read-params")
     */
    public function readParamsAction(){
        $param = $this->container->getParameter('appApiKey');
        return new Response($param);
    }
}
