<?php

namespace AppBundle\Entity;
//use FOS\UserBundle\Entity\User as BaseUser;
use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
	* @var 
	* @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
	*/
	private $comments;

	
	/**
	* @var array
	* 
	* @ORM\Column(type="json_array")
	*/
	//protected $roles = [];
	
	 public function __construct()
    {
        parent::__construct();
        
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
	
	/**
	*
	* @return array (Role|string)[]
	*/
	/*
	public function getRoles($roles)
	{
		return $this->roles;
	}
	*/

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
	
	 public function getUserRoles(User $user)
    {
        return $user->getRoles();
    }
	
	
}
