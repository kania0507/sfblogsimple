<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CategoryType;
use AppBundle\Entity\Category;

class CategoryController extends Controller
{
	/**
     * @Route("/categories/", name="categories")
     */
	public function indexAction(Request $request)
    {
			$repoCategories = $this->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Category');
			$categories = $repoCategories->findAll();
		
		
		$qb=$this->getDoctrine()
			->getManager()
			->createQueryBuilder()
			->from('AppBundle:Category', 'p')
			->select('p');
			
			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
			$qb, $request->query->get('page',1), 20);
					
        return $this->render('category/index.html.twig', array('categories' => $pagination));
	}
	
	
	/**
	* @Route("/categories/{id}", name="category_show")
	*      requirements = {"id" = "\d+"}
	*/
	public function showAction($id)
	{				
	      
	
		$posts = new \AppBundle\Entity\Post;
	
		$repository = $this->getDoctrine()->getRepository(Category::class);
		$category = $repository->find($id);
				
		$posts = $category->getPosts();
			
		if (!$category) {
			throw $this->createNotFoundException(
				'No category found for id '.$id
			);
		}
  
		 return $this->render('category/show.html.twig', array('category'=>$category, 'posts'=>$posts));		    
	}

	
		
	/**
	* @Route("/category/add/", name="category_add")	
	* 
	*/
	public function addAction(Request $request)
	{	
		$form=null;
						 
        $category = new Category();
                      
		if ($user=$this->getUser()){					
		
			$form = $this->createForm(new CategoryType(), $category);
			$form->handleRequest($request);
			
			if ($form->isValid())
			{
				$category = $form->getData(); 
				 
				$em=$this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();
			
				$this->addFlash('success', "Kategorię dodano.");
				return $this->redirectToRoute('homepage');
			
			}
		} else echo "Musisz być zalogowany, aby dodać nową kategorię.";
		
		
		
		
        return $this->render('category/add.html.twig', array(        
			'form'=>is_null($form)?$form:$form->createView(),
			
        ));
		

        
	
	}

	
}
