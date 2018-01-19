<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User //extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
	* @var 
	* @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
	*/
	private $comments;

	
	 public function __construct()
    {
        parent::__construct();
        // your own logic
    }
	

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
