<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="nrHouse", type="integer")
     */
    private $nrHouse;

    /**
     * @var string
     *
     * @ORM\Column(name="nrFlat", type="string", length=255)
     */
    private $nrFlat;


    
    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="address")
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
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set nrHouse
     *
     * @param integer $nrHouse
     * @return Address
     */
    public function setNrHouse($nrHouse)
    {
        $this->nrHouse = $nrHouse;

        return $this;
    }

    /**
     * Get nrHouse
     *
     * @return integer 
     */
    public function getNrHouse()
    {
        return $this->nrHouse;
    }

    /**
     * Set nrFlat
     *
     * @param string $nrFlat
     * @return Address
     */
    public function setNrFlat($nrFlat)
    {
        $this->nrFlat = $nrFlat;

        return $this;
    }

    /**
     * Get nrFlat
     *
     * @return string 
     */
    public function getNrFlat()
    {
        return $this->nrFlat;
    }

    /**
     * Add users
     *
     * @param \ContactBookBundle\Entity\User $users
     * @return Address
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
