<?php

namespace AppBundle\Controller;
//namespace AppBundle\Entity;
///namespace App\Repository;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\Comment;



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
	public function showAction(Post $post, Request $request)
	{	
		$form = null; 
		
		if ($user=$this->getUser())
		{
	
			$comment=new \AppBundle\Entity\Comment();
			$comment->setPost($post);
			$comment->setUser($user);
	
			$form = $this->createForm(new CommentType(), $comment);
			$form->handleRequest($request);
		
			if ($form->isValid())
			{
				$em=$this->getDoctrine()->getManager();
				$em->persist($comment);
				$em->flush();
			
				$this->addFlash('success', "Komentarz dodano.");
				return $this->redirectToRoute('post_show', array('id'=>$post->getId()));
			
			}
		}
		
		
		

		

/*		
$post = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->find($id);
		
		$comment=new \AppBundle\Entity\Comment();
		$comment->setPost($post);
		
	
		
		if (!$post) {
			throw $this->createNotFoundException(
				'No post found for id '.$id
			);
		}
*/
		if (!$post) {
			throw $this->createNotFoundException(
				'No post found for id '.$id
			);
		}

		 return $this->render('post/show.html.twig', array('post'=>$post, 'form'=>is_null($form)?$form:$form->createView()));
		//return new Response('Post: '.$post->getTitle());
		// return $this->render('product/show.html.twig', ['product' => $product]);
    
	}
	
}
