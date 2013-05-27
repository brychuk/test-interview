<?php

namespace Survey\IndexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Users
 */
class Users
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var float
     */
    private $shoeSize;

    /**
     * @var string
     */
    private $favouriteIceCream;

    /**
     * @var string
     */
    private $favouriteSuperhero;

    /**
     * @var string
     */
    private $favouriteMovieStar;

    /**
     * @var \DateTime
     */
    private $worldEndDate;

    /**
     * @var string
     */
    private $superbowlWinner;

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
     * Set id
     * @param integer $id
     * @return Users
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Users
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set shoeSize
     *
     * @param float $shoeSize
     * @return Users
     */
    public function setShoeSize($shoeSize)
    {
        $this->shoeSize = $shoeSize;
    
        return $this;
    }

    /**
     * Get shoeSize
     *
     * @return float 
     */
    public function getShoeSize()
    {
        return $this->shoeSize;
    }

    /**
     * Set favouriteIceCream
     *
     * @param string $favouriteIceCream
     * @return Users
     */
    public function setFavouriteIceCream($favouriteIceCream)
    {
        $this->favouriteIceCream = $favouriteIceCream;
    
        return $this;
    }

    /**
     * Get favouriteIceCream
     *
     * @return string 
     */
    public function getFavouriteIceCream()
    {
        return $this->favouriteIceCream;
    }

    /**
     * Set favouriteSuperhero
     *
     * @param string $favouriteSuperhero
     * @return Users
     */
    public function setFavouriteSuperhero($favouriteSuperhero)
    {
        $this->favouriteSuperhero = $favouriteSuperhero;
    
        return $this;
    }

    /**
     * Get favouriteSuperhero
     *
     * @return string 
     */
    public function getFavouriteSuperhero()
    {
        return $this->favouriteSuperhero;
    }

    /**
     * Set favouriteMovieStar
     *
     * @param string $favouriteMovieStar
     * @return Users
     */
    public function setFavouriteMovieStar($favouriteMovieStar)
    {
        $this->favouriteMovieStar = $favouriteMovieStar;
    
        return $this;
    }

    /**
     * Get favouriteMovieStar
     *
     * @return string 
     */
    public function getFavouriteMovieStar()
    {
        return $this->favouriteMovieStar;
    }

    /**
     * Set worldEndDate
     *
     * @param \DateTime $worldEndDate
     * @return Users
     */
    public function setWorldEndDate($worldEndDate)
    {
        $this->worldEndDate = $worldEndDate;
    
        return $this;
    }

    /**
     * Get worldEndDate
     *
     * @return \DateTime 
     */
    public function getWorldEndDate()
    {
        return $this->worldEndDate;
    }

    /**
     * Set superbowlWinner
     *
     * @param string $superbowlWinner
     * @return Users
     */
    public function setSuperbowlWinner($superbowlWinner)
    {
        $this->superbowlWinner = $superbowlWinner;
    
        return $this;
    }

    /**
     * Get superbowlWinner
     *
     * @return string 
     */
    public function getSuperbowlWinner()
    {
        return $this->superbowlWinner;
    }

    /**
     * Get user's full name
     *
     * @return string
     */
    public function getFullName(){
        return $this->getFirstName(). ' '. $this->getLastName();
    }

    public function prePersist()
    {
        print_r(1111);
        if( !empty($this->shoeSize) ){
            $this->shoeSize = (float) $this->shoeSize;
        }
        if( empty($this->favouriteIceCream) )
        {
            $this->setFavouriteIceCream('');
        }
        if( empty($this->favouriteMovieStar) )
        {
            $this->setFavouriteMovieStar('');
        }
        if( empty($this->favouriteSuperhero) )
        {
            $this->setFavouriteSuperhero('');
        }
        if( empty($this->worldEndDate) )
        {
            $this->setWorldEndDate( new \DateTime('0000-00-00'));
        }
        if( empty($this->superbowlWinner) )
        {
            $this->setSuperbowlWinner('');
        }
    }

    public function preUpdate()
    {
        print_r(2222);
        $this->prePersist();
    }
}