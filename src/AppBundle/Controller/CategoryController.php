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
	
/*
		$category = $this->getDoctrine()
		->getManager()
        ->getRepository("AppBundle:Category")//"Category::class")
        ->find($id);
*/
		/*
		$category = $this->getDoctrine()
				->getRepository('AppBundle:Category')
				->findBy(array('id' => $category->getId()));
*/
		//$cat_repo=$this->getDoctrine()->getEntityManager()->getRepository("AppBundle:Category");
		//$cat_repo=
		//$category=$this->getDoctrine()->getRepository("AppBundle:Category")->find($category->id);
		//$category=$cat_repo->find($id);
		
		//new \AppBundle\Entity\Category();
		
	
		if (!$category) {
			throw $this->createNotFoundException(
				'No category found for id '.$id
			);
		}
			
		

		 return $this->render('category/show.html.twig', array('category'=>$category));
		
    
	}
	
}
