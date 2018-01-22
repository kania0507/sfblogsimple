<?php

namespace AppBundle\Controller;
//namespace AppBundle\Entity;
///namespace App\Repository;
use AppBundle\Entity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\CommentType;

//use Doctrine\ORM\Mapping as ORM;
//use Doctrine\ORM\EntityManager;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
	 
    public function indexAction(Request $request)
    {
		
		
		
		$repoPosts = $this->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Post');
			$posts = $repoPosts->findAll();
		
		
		$qb=$this->getDoctrine()
			->getManager()
			->createQueryBuilder()
			->from('AppBundle:Post', 'p')
			->select('p');
			
			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
			$qb, $request->query->get('page',1), 20);
			
		
        return $this->render('post/index.html.twig', array('posts' => $pagination
		//	'posts' => $posts
         //   'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
	
	/**
	* @Route("/post/{id}", name="post_show")
	*/
	public function showAction($id)
	{				
		$post = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->find($id);
	
		$comment=new \AppBundle\Entity\Comment();
		$comment->setPost($post);
		$form = $this->createForm(new CommentType());
	
		
		if (!$post) {
			throw $this->createNotFoundException(
				'No post found for id '.$id
			);
		}

		 return $this->render('post/show.html.twig', array('post'=>$post, 'form'=>$form->createView()));
		//return new Response('Post: '.$post->getTitle());
		// return $this->render('product/show.html.twig', ['product' => $product]);
    
	}
	
}
