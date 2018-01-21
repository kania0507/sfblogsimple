<?php 
namespace ProductBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$date =  new \DateTime("now");
        // create 20 products! Bam!
        for ($i = 0; $i < 90; $i++) {
            $post = new Post();
            $post->setTitle('Post '.$i);
            $post->setContent('lorem ipsum aokoaj fioafj iajfiaj oaij fioajf aoifj oafjo aijfaiojaoij'.$i);
			
			 $post->setCreated($date);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
?>