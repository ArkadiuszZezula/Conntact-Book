<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\EmailRepository")
 */
class Email
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="addressEmail", type="string", length=255)
     */
    private $addressEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    
    
    
    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="email")
    */
    private $users;
    
    public function __construct() {
    $this->users = new ArrayCollection();
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
     * Set addressEmail
     *
     * @param string $addressEmail
     * @return Email
     */
    public function setAddressEmail($addressEmail)
    {
        $this->addressEmail = $addressEmail;

        return $this;
    }

    /**
     * Get addressEmail
     *
     * @return string 
     */
    public function getAddressEmail()
    {
        return $this->addressEmail;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Email
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add users
     *
     * @param \ContactBookBundle\Entity\User $users
     * @return Email
     */
    public function addUser(\ContactBookBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \ContactBookBundle\Entity\User $users
     */
    public function removeUser(\ContactBookBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
