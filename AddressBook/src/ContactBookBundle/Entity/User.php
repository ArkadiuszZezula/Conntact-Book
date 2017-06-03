<?php

namespace ContactBookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ContactBookBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="userName", type="string", length=255)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="userSurname", type="string", length=255)
     */
    private $userSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="userDescription", type="string", length=255)
     */
    private $userDescription;


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
     * Set userName
     *
     * @param string $userName
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userSurname
     *
     * @param string $userSurname
     * @return User
     */
    public function setUserSurname($userSurname)
    {
        $this->userSurname = $userSurname;

        return $this;
    }

    /**
     * Get userSurname
     *
     * @return string 
     */
    public function getUserSurname()
    {
        return $this->userSurname;
    }

    /**
     * Set userDescription
     *
     * @param string $userDescription
     * @return User
     */
    public function setUserDescription($userDescription)
    {
        $this->userDescription = $userDescription;

        return $this;
    }

    /**
     * Get userDescription
     *
     * @return string 
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }
}
