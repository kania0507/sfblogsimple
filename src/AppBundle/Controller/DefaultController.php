<?php

namespace AppBundle\Controller;
//namespace AppBundle\Entity;
///namespace App\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;





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
		
		$categories=array();//new \AppBundle\Entity\Category();
		
		
		$repoPosts = $this->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Post');
			$posts = $repoPosts->findAll();

		//	print_r($posts);
			//$posts=$repoPosts->findOneByIdJoinedToCategory($posts->getId());
		
			
			/*
			$qb = $this->createQueryBuilder('a');
$qb->add('select', 'a');
$qb->leftJoin('a.category', 'c');
$qb->where('c.name LIKE :category'); 
$qb->setParameter('category', $slug);
$qb->getQuery()->getResult();
*/

			//foreach ($posts->getCategories() as $categories) {
			//	echo $categories->getName(); }
				
			//foreach ($posts as $post)
			//	$categories[$post->getId()] = $post->getCategories();
		
		$qb=$this->getDoctrine()
			->getManager()
			->createQueryBuilder()
			->from('AppBundle:Post', 'p')
			->select('p');
			
			$paginator = $this->get('knp_paginator');
			$pagination = $paginator->paginate(
			$qb, $request->query->get('page',1), 20);
			
		
		/*
		
		public function findWithoutArticle($article_id)
{
    $qb = $this->em->createQueryBuilder()
                   ->select('c')
                   ->from('Category', 'c')
                   ->leftJoin('c.article', 'a')
                   ->where('a.article_id <> :articleId')
                   ->setParameter('articleId', $article_id);

    return $qb->getQuery()->getResult();
}
		*/
		
		//print_r($categories);
        return $this->render('post/index.html.twig', array('posts' => $pagination,
		'categories'=>$categories
		//	'posts' => $posts
         //   'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
	
	
	public function findOneByIdJoinedToCategory($postId)
{
    return $this->createQueryBuilder('p')
        // p.category refers to the "category" property on product
        ->innerJoin('p.category_id', 'c')
        // selects all the category data to avoid the query
        ->addSelect('c')
        ->andWhere('p.id = :id')
        ->setParameter('id', $postId)
        ->getQuery()
        ->getOneOrNullResult();
}

	
	/**
	* @Route("/posts/{id}", name="post_show")
	*/
	public function showAction(Post $post, Request $request)
	{	
		$form = null; 
		
		
		$categories = $post->getCategories()->getName();
		
		if ($user=$this->getUser())
		{
	
			//$categories=new \AppBundle\Entity\Category();
			//foreach ($post->getCategories() as $cat) {
//				$categories=$cat->getName();				
			//}
			$categories = $post->getCategory()->getName();
			
			
			$categories->getPost($post);
			
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

		 return $this->render('post/show.html.twig', array('post'=>$post, 
			'categories'=>$categories,
			'form'=>is_null($form)?$form:$form->createView()));
		//return new Response('Post: '.$post->getTitle());
		// return $this->render('product/show.html.twig', ['product' => $product]);
    
	}
	
	
	
	/**
	* @Route("/add", name="post_add")	
	* 
	*/
	//@ParamConverter("post", class="AppBundle:Post")
	public function addAction(Request $request)
	{	
		$form=null;
		//$post='';
		
		 // create a task and give it some dummy data for this example
        $post = new Post();
        $post->setTitle('Write a blog post');
        //$task->setDueDate(new \DateTime('tomorrow'));

      
		if ($user=$this->getUser()){
			$form = $this->createForm(new PostType(), $post);
			$form->handleRequest($request);
			
			if ($form->isValid())
			{
				$post = $form->getData(); 
				 
				$em=$this->getDoctrine()->getManager();
				$em->persist($post);
				$em->flush();
			
				$this->addFlash('success', "Post dodano.");
				return $this->redirectToRoute('homepage');//, array('id'=>$post->getId()));
			
			}
		} else echo "Musisz być zalogowany, aby dodać nowy post.";
		
        return $this->render('post/add.html.twig', array(        
			'form'=>is_null($form)?$form:$form->createView()
        ));
		

        
	
	}
	public function findAllCatNameAsc()
	{
		return $this->getEntityManager()
          ->createQuery(
            'SELECT c FROM AppBundle::Category c ORDER BY c.name ASC'
          )
          ->getResult();
	}
	
}
