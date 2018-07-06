<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Table(name="app_users")
* @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
*/
class Usuario implements UserInterface, \Serializable 
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=25, unique=true)
    */

    private $username;
    /**
    * @ORM\Column(type="string", length=64)
    */ 

    private $password;

    /**
    * @ORM\Column(type="string", length=60, unique=true)
    */
    private $email;

    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    public function __construct ()
    {
        $this->isActive = true ;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail ($email)
    {
        $this->email = $email;
    }

    public function getUsername ()
    {
        return $this->username;
    }

    public function setUsername ($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword ()
    {
        return $this->plainPassword;
    }
    
    public function setPlainPassword ($password)
    {
        $this​->plainPassword = $password;
    }

    public function getPassword ()
    {
        return $this->password;
    }
    
    public function setPassword ($password)
    {
        $this->password = $password;
    }
    
    public  function getSalt ()
    {
        return null ;
    }
    
    /**
    * Returns the roles granted to the user.
    *
    * <code>
    * public function getRoles()
    * {
    *
    * return array('ROLE_USER');
    * }
    * </code>
    *
    * Alternatively, the roles might be stored on a ``roles`` property,
    * and populated in any number of different ways when the user object
    * is created.
    *
    * @return (Role|string)[] The user roles
    */
    public function getRoles ()
    {
        return array ( 'ROLE_USER' );
    }
    
    /**
    * Removes sensitive data from the user.
    *
    * This is important if, at any given point, sensitive information like
    * the plain-text password is stored on this object.
    */

    public function eraseCredentials()
    {
    // TODO: Implement eraseCredentials() method.
    }

    /** @see \Serializable::serialize() */
    public function  serialize ()
    {
        return serialize( array (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));      
    }

    /** @see \Serializable::unserialize() */
    public function unserialize ($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
    // see section on salt below
    // $this->salt
        ) = unserialize($serialized);
    }
}
