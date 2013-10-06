<?php

namespace Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $birthdate;

    /**
     * @var string
     */
    private $source_id = '';

    /**
     * @var boolean
     */
    private $active = false;

    /**
     * @var \Model\Token
     */
    private $token;


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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
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
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set source_id
     *
     * @param string $sourceId
     * @return User
     */
    public function setSourceId($sourceId)
    {
        $this->source_id = $sourceId;

        return $this;
    }

    /**
     * Get source_id
     *
     * @return string 
     */
    public function getSourceId()
    {
        return $this->source_id;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set token
     *
     * @param \Model\Token $token
     * @return User
     */
    public function setToken(\Model\Token $token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return \Model\Token 
     */
    public function getToken()
    {
        return $this->token;
    }

	public function getAge()
	{
		$date = new \DateTime('now');
		return $date->diff($this->getBirthdate())->y;
	}

    /**
     * @var \Model\Key
     */
    private $key;


    /**
     * Set key
     *
     * @param \Model\Key $key
     * @return User
     */
    public function setKey(\Model\Key $key = null)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return \Model\Key 
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * @var \DateTime
     */
    private $created_at;


    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
