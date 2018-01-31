<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

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
	*/
	public function showAction($id)
	{				
		$repository = $this->getDoctrine()->getRepository(Category::class);
		$category = $repository->find($id);
	
	
	$qb = $this->createQueryBuilder('a');
$qb->from('AppBundle:Category');
	$qb->add('select', 'a');
$qb->leftJoin('a.category', 'c');
$qb->where('c.name LIKE :category'); /* i have guessed a.name */
$qb->setParameter('category', $slug);
$qb->getQuery()->getResult();

var_dump($qb);

			
		if (!$category) {
			throw $this->createNotFoundException(
				'No category found for id '.$id
			);
		}

		 return $this->render('category/show.html.twig', array('category'=>$category));		    
	}	
}
