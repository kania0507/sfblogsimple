<?php

namespace AppBundle\Controller;
//namespace AppBundle\Entity;
///namespace App\Repository;
use AppBundle\Entity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


//use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\EntityManager;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
	 
    public function indexAction()//Request $request)
    {
		
		
		
		$repoPosts = $this->getDoctrine()
			->getEntityManager()
			->getRepository('AppBundle:Post');
			$posts = $repoPosts->findAll();
		
		
        return $this->render('post/index.html.twig', array(
			'posts' => $posts
         //   'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
	
	/**
	* @Route("/post/{id}", name="post_show")
	*/
	public function showAction($id)
	{
		$post = $this->getDoctrine()
        ->getRepository('Post::class')
        ->find($id);
		
		
		if (!$post) {
			throw $this->createNotFoundException(
				'No post found for id '.$id
			);
		}

		 return $this->render('post/show.html.twig', array('post'=>$post));
		//return new Response('Post: '.$post->getTitle());
		// return $this->render('product/show.html.twig', ['product' => $product]);
    
	}
	
}
